<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Agar user session me nahi hai
        if(!Session::has('user_id')){
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        return $next($request);
    }
}
