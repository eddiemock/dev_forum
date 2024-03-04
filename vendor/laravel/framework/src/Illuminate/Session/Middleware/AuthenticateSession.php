<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;

class AuthenticateSession
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
{
    if (! $request->hasSession() || ! $request->user()) {
        return $next($request);
    }

    $guard = $this->auth->guard();

    if ($this->guardUsesRecaller($guard) && $request->cookies->has($guard->getRecallerName())) {
        $passwordHash = explode('|', $request->cookies->get($guard->getRecallerName()))[2] ?? null;

        if (! $passwordHash || $passwordHash != $request->user()->getAuthPassword()) {
            $this->logout($request);
        }
    }

    if (! $request->session()->has('password_hash')) {
        $this->storePasswordHashInSession($request);
    }

    if ($request->session()->get('password_hash') !== $request->user()->getAuthPassword()) {
        $this->logout($request);
    }

    return tap($next($request), function () use ($request, $guard) {
        if (! is_null($guard->user())) {
            $this->storePasswordHashInSession($request);
        }
    });
}

    protected function storePasswordHashInSession($request)
    {
        if (! $request->user()) {
            return;
        }

        $request->session()->put('password_hash', $request->user()->getAuthPassword());
    }

    protected function logout($request)
    {
        $this->auth->guard()->logout();

        $request->session()->invalidate();

        throw new AuthenticationException('Unauthenticated.');
    }

    protected function guardUsesRecaller($guard)
{
    return method_exists($guard, 'getRecallerName');
}
}
?>