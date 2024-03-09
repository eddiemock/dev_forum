<?php

namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->user() || !auth()->user()->roles()->whereIn('name', $roles)->exists()) {
        // Redirect or respond with unauthorized if the user does not have any of the required roles
        abort(403, 'Unauthorized access.');
    }

    return $next($request);
}

}
