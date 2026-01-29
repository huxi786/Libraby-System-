<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| 1. GUEST ROUTES (Login, Register, Password Reset)
|--------------------------------------------------------------------------
| Ye pages wo log dekh sakte hain jo Login nahi hain.
*/
Route::middleware(['guest', 'prevent-back-history'])->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Password Reset (Isko yahan move kiya hai taake guests access kar sakein)
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| 2. GENERAL AUTH ROUTES (Logout & Pending Status)
|--------------------------------------------------------------------------
| Ye routes har logged-in banda access kar sakta hai (chahe Pending ho ya Active).
| IMPORTANT: 'approval.notice' yahan hona zaroori hai, 'approved' group ke bahar.
*/
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

    // ✅ PENDING PAGE: Pending users yahan redirect honge
    Route::get('/pending-approval', function () {
        return view('auth.pending'); 
    })->name('approval.notice');

    // Check Status (For AJAX updates)
    Route::get('/check-fresh-status', function () {
        return response()->json(['status' => \App\Models\User::where('id', auth()->id())->value('status')]);
    })->name('check.fresh.status');
});

/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES
|--------------------------------------------------------------------------
| Sirf 'role' => 'admin' wale yahan jasakte hain.
*/
Route::middleware(['auth', 'admin', 'prevent-back-history'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/welcome', [AdminController::class, 'welcome'])->name('admin.welcome');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/user/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.user.approve');
    Route::delete('/user/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.delete');

    // Requests & Books Management
    Route::get('/requests', [AdminController::class, 'showIssueRequests'])->name('admin.requests');
    Route::get('/request/approve/{id}', [AdminController::class, 'approveIssue'])->name('admin.issue.approve');
    Route::get('/request/reject/{id}', [AdminController::class, 'rejectIssue'])->name('admin.issue.reject');

    // Book Resource
    Route::resource('books', BookController::class);
    Route::get('/book/approve/{id}', [AdminController::class, 'approveBook'])->name('admin.book.approve');
    Route::get('/book/reject/{id}', [AdminController::class, 'rejectBook'])->name('admin.book.reject');

    // Chat System
    Route::post('/messages/reply/{userId}', [AdminController::class, 'replyMessage'])->name('admin.reply');
    Route::get('/messages/{userId?}', [AdminController::class, 'messages'])->name('admin.messages');

    // Notifications & Stats
    Route::get('/check-new-users', function () {
        $users = \App\Models\User::where('status', 'pending')->latest()->get();
        return response()->json(['count' => $users->count(), 'users' => $users]);
    })->name('admin.check.new.users');
    Route::get('/requests/fetch', [AdminController::class, 'fetchPendingRequests'])->name('admin.requests.fetch');
    Route::get('/global-counts', [AdminController::class, 'getGlobalCounts'])->name('admin.global.counts');
    
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
});

/*
| 4. USER ROUTES (Approved Only)
|--------------------------------------------------------------------------
| Yahan sirf 'Active' status wale users aaskte hain.
| Agar 'Pending' user yahan aane ki koshish karega, to Middleware usay wapis
| 'approval.notice' par bhej dega.
*/
Route::middleware(['auth', 'approved', 'prevent-back-history'])->group(function () {
    
    Route::get('/', [BookController::class, 'home'])->name('home');
    Route::get('/about', [UserController::class, 'about'])->name('about');

    // Books Browsing & Searching
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/browse/{category}', [BookController::class, 'booksByCategory'])->name('books.category');
    Route::post('/books/{book}/request', [BookController::class, 'requestBook'])->name('books.request');
    Route::delete('/books/request/{id}/cancel', [BookController::class, 'cancelRequest'])->name('books.cancel');

    // Dashboard & Receipt
    Route::get('/my-dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/receipt/{id}', [UserController::class, 'showReceipt'])->name('user.receipt');
    Route::get('/return-book/{id}', [UserController::class, 'returnBook'])->name('book.return');
    Route::get('/my-status-updates', [UserController::class, 'checkStatus'])->name('user.status.check');

    // Contact / Chat
    Route::get('/contact', [UserController::class, 'contact'])->name('contact');
    Route::post('/contact/send', [UserController::class, 'sendMessage'])->name('contact.send');
    Route::post('/contact/send-ajax', [UserController::class, 'sendMessageAjax'])->name('contact.send.ajax');
});

/*
|--------------------------------------------------------------------------
| 5. PUBLIC / MISC ROUTES
|--------------------------------------------------------------------------
*/
// Ye publicly accessible hai taake koi bhi book details dekh sake (optionally aap isay group 4 me dal sakte hain)
Route::get('/book/details/{id}', [BookController::class, 'getBookDetails'])->name('book.details');

// Practice Routes
Route::get('/practice', [PracticeController::class, 'index']);
Route::get('/practice/ajax-data', [PracticeController::class, 'testAjax'])->name('practice.ajax');

Route::get('/faq', [BookController::class, 'faq'])->name('faq');
Route::get('/rules', [App\Http\Controllers\UserController::class, 'rules'])->name('rules');

// routes/web.php ke end mein dalein
Route::get('/time-check', function () {
    return [
        'Config Timezone' => config('app.timezone'), // Laravel kya soch raha hai
        'Server Timezone' => date_default_timezone_get(), // Server kya soch raha hai
        'Now (Carbon)' => \Carbon\Carbon::now()->format('Y-m-d h:i A'), // Abhi ka time
        'Now (PHP)' => date('Y-m-d h:i A'), // PHP ka raw time
    ];
});

// Google OAuth Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);