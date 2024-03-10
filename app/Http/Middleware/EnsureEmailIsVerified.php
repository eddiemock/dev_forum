<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is logged in and if their email has been verified.
        if (Auth::check() && Auth::user()->email_verified_at === null) {
            // Redirect to a specific route or return a response
            // indicating the need for email verification.
            return redirect('email/verify')->with('error', 'Please verify your email first.');
        }

        return $next($request);
    }
}
