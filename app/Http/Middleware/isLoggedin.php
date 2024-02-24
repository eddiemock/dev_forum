<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line to use the Log facade

class isLoggedin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('username')) {
            // Add a log statement here
            Log::info('User already logged in. Redirecting...', ['username' => session('username')]);
            
            return redirect('/');
        }
        return $next($request);
    }
}
