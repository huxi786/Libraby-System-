<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // FIX: Pehle ye sirf 'is_admin' check kar raha tha.
        // Ab hum check kar rahe hain ke Role 'admin' ho.
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->is_admin == 1)) {
            return $next($request);
        }

        // Agar admin nahi hai, to User Dashboard par wapis bhej do
        return redirect()->route('home')->with('error', 'You do not have admin access.');
    }
}