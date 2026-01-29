<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller; // 🟢 FIX: Base Controller Import kiya

class PracticeController extends Controller
{
    // 1. Page Dikhane ke liye
    public function index() {
        // Make sure 'resources/views/practice.blade.php' exists
        return view('practice'); 
    }

    // 2. AJAX Testing ke liye
    public function testAjax() {
        return response()->json([
            'status' => 'success',
            'message' => 'Mubarak ho! AJAX chal gaya! 🚀', 
            'random_number' => rand(100, 999)
        ]);
    }
}