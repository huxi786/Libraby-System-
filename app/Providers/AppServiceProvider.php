<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; 
use Illuminate\Pagination\Paginator; // ✅ Bootstrap Pagination ke liye (Recommended)

// Models Import
use App\Models\Borrow;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🟢 FIX 1: Ye code sabse UPPAR hona chahiye (Login page ke liye bhi)
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {
            URL::forceScheme('https');
        }

        // 🟢 FIX 2: Bootstrap Pagination (Agar design toot raha ho to ye zaroori hai)
        Paginator::useBootstrap();

        // Database key length fix
        Schema::defaultStringLength(191);

        // View Composer (Stats Logic)
        View::composer('*', function ($view) {

            // Default values
            $requestCount = 0;
            $userCount = 0;
            $msgCount = 0;

            // Check: Login & Admin logic only for Stats
            if (Auth::check() && Auth::user()->role === 'admin') {
                try {
                    $requestCount = Borrow::where('status', 'pending')->count();
                    $userCount = User::where('role', '!=', 'admin')->count();
                    // $msgCount = Message::where('is_read', 0)->count();
                } catch (\Exception $e) {
                    // Ignore errors if table missing
                }
            }

            // View ko variables pass karein
            $view->with('requestCount', $requestCount)
                ->with('userCount', $userCount)
                ->with('msgCount', $msgCount);
        });
    }
}