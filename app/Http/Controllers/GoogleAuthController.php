<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // 1. Send user to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle the return from Google
    public function handleGoogleCallback()
    {
        try {
            // Get user details from Google
            $googleUser = Socialite::driver('google')->user();

            // Check if this Google user already exists in our DB
            $findUser = User::where('google_id', $googleUser->id)->first();

            if ($findUser) {
                // ✅ Case 1: User exists with Google ID -> Login directly
                Auth::login($findUser);
                return redirect()->route('user.dashboard')->with('success', 'Welcome back!');
            
            } else {
                // Check if user exists by EMAIL (e.g., they registered manually before)
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // ✅ Case 2: Email exists but Google ID doesn't -> Link account & Login
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::login($existingUser);
                    return redirect()->route('user.dashboard')->with('success', 'Account linked successfully!');
                } else {
                    // ✅ Case 3: New User -> Create Account & Login
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'role' => 'user', // Default role
                        'password' => Hash::make(Str::random(16)) // Random secure password
                    ]);

                    Auth::login($newUser);
                    return redirect()->route('user.dashboard')->with('success', 'Account created successfully!');
                }
            }

        } catch (\Exception $e) {
            // ❌ Handle Errors
            return redirect()->route('login')->with('error', 'Something went wrong with Google Login: ' . $e->getMessage());
        }
    }
}