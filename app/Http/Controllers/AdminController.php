<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==========================================
    // SECTION 1: BORROW REQUESTS (Issue/Return)
    // ==========================================

    public function showIssueRequests()
    {
        $requests = Borrow::where('status', 'pending')
            ->with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.requests', compact('requests'));
    }

    public function approveIssue($id)
    {
        $borrow = Borrow::find($id);

        if ($borrow) {
            $borrow->status = 'issued';
            $borrow->issued_date = now();
            $borrow->due_date = now()->addDays(14);
            $borrow->save();

            // ✅ CHANGED: Redirect back with success message
            return redirect()->back()->with('success', 'Book issued successfully!');
        }

        return redirect()->back()->with('error', 'Request not found.');
    }

    public function rejectIssue($id)
    {
        $borrow = Borrow::find($id);

        if ($borrow) {
            $borrow->status = 'rejected';
            $borrow->save();

            // ✅ CHANGED: Redirect back with success message
            return redirect()->back()->with('success', 'Request rejected successfully.');
        }

        return redirect()->back()->with('error', 'Request not found.');
    }

    // ==========================================
    // SECTION 2: DASHBOARD & USERS
    // ==========================================

    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $requests = Borrow::where('status', 'pending')->with(['user', 'book'])->get();
        $pendingUsers = User::where('status', 'pending')->get();

        return view('admin.dashboard', compact('totalBooks', 'totalUsers', 'requests', 'pendingUsers'));
    }

    public function users()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        $activeUsers = User::where('status', 'active')->get();
        return view('admin.user', compact('pendingUsers', 'activeUsers'));
    }

    public function approveUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 'active';
            $user->save();

            // ✅ CHANGED: Redirect back with success message
            return redirect()->back()->with('success', 'User approved successfully!');
        }

        return redirect()->back()->with('error', 'User not found!');
    }

    public function destroyUser($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete yourself!');
        }

        $user = User::find($id);

        if ($user) {
            $user->delete();
            // ✅ CHANGED: Redirect back with success message
            return redirect()->back()->with('success', 'User deleted successfully!');
        }

        return redirect()->back()->with('error', 'User not found!');
    }

    // ==========================================
    // SECTION 3: BOOK APPROVALS
    // ==========================================

    public function approveBook($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->status = 'approved';
            $book->save();
            return back()->with('success', 'Book approved successfully!');
        }
        return back()->with('error', 'Book not found.');
    }

    public function rejectBook($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->status = 'rejected';
            $book->save();
            return back()->with('success', 'Book rejected.');
        }
        return back()->with('error', 'Book not found.');
    }

    // ==========================================
    // SECTION 4: CHAT SYSTEM
    // ==========================================

    public function welcome()
    {
        return view('welcome');
    }

    // 1. PAGE LOAD (Loads Chat History based on ID in URL)
    public function messages($userId = null)
    {
        // Sidebar list
        $userIds = Message::distinct()->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();

        // Chat History Load
        $selectedUser = null;
        $chat = [];

        if ($userId) {
            $selectedUser = User::find($userId);
            if ($selectedUser) {
                $chat = Message::where('user_id', $userId)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }

        return view('admin.messages', compact('users', 'selectedUser', 'chat'));
    }

    // 2. SEND REPLY (Standard Form Submit)
   public function replyMessage(Request $request, $userId)
{
    $request->validate(['message' => 'required']);
    
    $user = User::find($userId);

    if ($user) {
        Message::create([
            'user_id' => $userId,
            'name'    => 'Admin', 
            'email'   => $user->email,
            'subject' => 'Support Reply',
            'message' => $request->message,
            'sender'  => 'admin' 
        ]);

        // 🟢 FIX: Ab JSON nahi, balki Page Redirect hoga success message ke sath
        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    return redirect()->back()->with('error', 'User not found.');
}
    // NOTE: 'fetchChat', 'fetchPendingRequests', 'getGlobalCounts' deleted 
    // because we are no longer using AJAX Polling.

public function analytics()
{
    // 1. Basic Counts
    $totalUsers = User::where('role', 'user')->count();
    $totalBooks = Book::count();
    // Assuming 'returned' books generated some fine/fee. Adjust column name if needed.
    // Filhal hum dummy revenue calculate kar rahe hain based on returned books
    $totalRevenue = Borrow::where('status', 'returned')->count() * 50; // $50 per book dummy
    $activeBorrows = Borrow::where('status', 'issued')->count();

    // 2. User Growth (Last 7 Days) - Graph 1
    $userGrowth = User::select(DB::raw("COUNT(*) as count"), DB::raw("DATE(created_at) as date"))
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    // 3. Borrow/Revenue Trends (Last 7 Months) - Graph 2
    $monthlyActivity = Borrow::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month"))
        ->where('created_at', '>=', Carbon::now()->subMonths(7))
        ->groupBy('month')
        ->orderBy('created_at', 'ASC') // Note: Real DB might need specific grouping
        ->pluck('count', 'month');

    // 4. Recent Activities (Table)
    $recentActivities = Borrow::with(['user', 'book'])->latest()->take(5)->get();

    return view('admin.analytics', compact(
        'totalUsers', 'totalBooks', 'totalRevenue', 'activeBorrows', 
        'userGrowth', 'monthlyActivity', 'recentActivities'
    ));
}



}
