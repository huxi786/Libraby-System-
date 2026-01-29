<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApproval
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Login check
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Admin ko kabhi mat roko
        if ($user->role === 'admin') {
            return $next($request);
        }

        // 3. Agar User 'Active' nahi hai, to wapis Pending Page par bhejo
        // NOTE: Humne check lagaya hai ke agar wo already 'approval.notice' route par nahi hai tabhi redirect kare, warna loop ban jayega.
        if ($user->status !== 'active' && !$request->routeIs('approval.notice')) {
            return redirect()->route('approval.notice');
        }

        return $next($request);
    }
}