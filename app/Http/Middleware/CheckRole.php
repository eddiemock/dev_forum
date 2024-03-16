<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is logged in and if their role matches any of the roles needed
        if (!auth()->user() || !in_array(auth()->user()->role->name, $roles)) {
            // Redirect or respond with unauthorized if the user does not have any of the required roles
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
