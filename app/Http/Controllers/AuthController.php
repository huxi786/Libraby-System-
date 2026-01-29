<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // --- LOGIN VIEW ---
    public function showLogin()
    {
        return view('auth.login');
    }

    // --- LOGIN LOGIC (Yahan Check Lagega) ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 1. Agar ADMIN hai -> Dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // 2. Agar USER hai
            if ($user->role === 'user') {
                
                // ✅ Check: Agar Pending hai to 'Pending Page' par phenk do
                if ($user->status === 'pending') {
                    return redirect()->route('approval.notice');
                }

                // ✅ Check: Agar Active hai to 'Dashboard' par jane do
                if ($user->status === 'active') {
                    return redirect()->route('user.dashboard');
                }
            }
        }

        return back()->with('error', 'Invalid email or password.');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // --- REGISTER VIEW ---
    public function showRegister()
    {
        return view('auth.register');
    }

    // --- REGISTER LOGIC (Yahan wapis Pending karenge) ---
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'status' => 'pending', // 👈 Wapis Pending kar diya
        ]);

        // Option A: Register ke baad Login page par bhejo
        return redirect()->route('login')->with('success', 'Account created! Please wait for Admin approval.');

        // Option B: (Agar aap chahte hain register hoty hi khud login hokar pending page par jaye, to niche wali lines uncomment karein)
        // Auth::login($user);
        // return redirect()->route('approval.notice');
    }
}