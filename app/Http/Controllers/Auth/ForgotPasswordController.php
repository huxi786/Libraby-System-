<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    // Step 1: Email Form Dikhao (Forgot Password Page)
    public function showLinkRequestForm() {
        // ❌ GALTI YAHAN THI: Tum 'reset-password' return kar rahe thay.
        // ✅ FIX: Yahan hum 'forgot-password' file return karenge.
        return view('auth.forgot-password'); 
    }

    // Step 2: Email Send Karo
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Step 3: Reset Form Dikhao (Link Click Karny Par)
    public function showResetForm(Request $request, $token = null) {
        // Ye function 'reset-password' file kholga aur Token pass karega
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    // Step 4: Final Password Update
    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}