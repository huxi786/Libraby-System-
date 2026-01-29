<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;
use Illuminate\Support\Facades\Auth;

class BookRequestController extends Controller
{
    // 1. User ki Request Save karna (AJAX se)
    public function store(Request $request) {
        $request->validate([
            'book_title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255',
        ]);

        BookRequest::create([
            'user_id' => Auth::id(),
            'book_title' => $request->book_title,
            'author_name' => $request->author_name,
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Request Sent Successfully!']);
    }

    // 2. Admin ke liye Notification Count (AJAX se)
    public function getPendingRequestsCount() {
        $count = BookRequest::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }
}