<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookController extends Controller
{
    // ==========================================
    // SECTION 1: USER FEATURES (Browsing & Stats)
    // ==========================================

    // --- 1. USER HOME PAGE (STATS) ---
    public function home()
    {
        $activeBooksCount = 0;
        $returnedBooksCount = 0;
        $dueSoonCount = 0;

        if (Auth::check()) {
            $userId = Auth::id();

            $activeBooksCount = Borrow::where('user_id', $userId)->where('status', 'issued')->count();
            $returnedBooksCount = Borrow::where('user_id', $userId)->where('status', 'returned')->count();
            $dueSoonCount = Borrow::where('user_id', $userId)->where('status', 'issued')
                ->whereBetween('due_date', [Carbon::now(), Carbon::now()->addDays(3)])->count();
        }

        return view('user.home', compact('activeBooksCount', 'returnedBooksCount', 'dueSoonCount'));
    }

    // --- 2. SEARCH BOOKS ---
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        // 🟢 FIX: Sidebar ke liye categories chahiye hoti hain
        $allCategories = Category::all();

        $books = Book::when($query !== '', function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%");
        })->with('category')->latest()->get();

        $title = $query !== '' ? 'Search results for "' . e($query) . '"' : 'Search Results';

        return view('user.books', compact('books', 'title', 'allCategories', 'query'));
    }

    // --- 3. FILTER BOOKS BY CATEGORY ---
    public function booksByCategory($categoryName)
    {
        // 🟢 FIX: Sidebar categories fetch karna zaroori hai
        $allCategories = Category::all();

        if ($categoryName == 'all') {
            $books = Book::with('category')->latest()->get();
            $currentTitle = 'All Books';
        } else {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                $books = Book::where('category_id', $category->id)->with('category')->latest()->get();
                $currentTitle = $category->name . ' Books';
            } else {
                $books = collect();
                $currentTitle = ucfirst($categoryName) . ' (Not Found)';
            }
        }

        // View mein variables pass kiye (currentTitle aur categoryName logic ke liye)
        return view('user.books', compact('books', 'allCategories', 'currentTitle', 'categoryName'));
    }


    // ==========================================
    // SECTION 2: BORROWING SYSTEM (Requests)
    // ==========================================

    // --- 4. REQUEST A BOOK ---
    public function requestBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Check if user already requested or has this book
        $existing = Borrow::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'issued'])
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have a request or issued copy of this book.');
        }

        Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your request has been sent to admin!');
    }

    // --- 5. CANCEL REQUEST ---
    public function cancelRequest($id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow || $borrow->user_id != auth()->id() || strtolower($borrow->status) != 'pending') {
            return back()->with('error', 'Unable to cancel request.');
        }

        $borrow->delete();
        return back()->with('success', 'Request cancelled successfully.');
    }


    // ==========================================
    // SECTION 3: ADMIN CRUD (Manage Books)
    // ==========================================

    // --- 6. INDEX (AJAX Supported) ---
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $books = Book::with('category')->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => 'success',
                'data' => $books
            ]);
        }

        $categories = Category::all();
        return view('books.index', compact('categories'));
    }

    // --- 7. SHOW (View Single Book Detail) ---
    public function show(Request $request, $id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'book' => $book
            ]);
        }

        return view('books.show', compact('book'));
    }

    // --- 8. CREATE (Show Form - Fallback) ---
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // --- 9. STORE (Add New Book - AJAX) ---
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:books,title',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'year' => 'nullable|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('book_covers', 'public');
        }

        Book::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'New book added successfully!'
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    // --- 10. EDIT (Fetch Data for Modal) ---
    public function edit($id)
    {
        $book = Book::find($id);

        if ($book) {
            return response()->json([
                'status' => 'success',
                'book' => $book
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
        }
    }

    // --- 11. UPDATE (Save Changes - AJAX) ---
    public function update(Request $request, $id)
    {

        $book = Book::find($id);

        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:books,title,' . $id, // Ignore current book ID
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'year' => 'nullable|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('book_covers', 'public');
        } else {
            // Agar nayi image nahi aayi to purani wali hi rakho
            unset($data['image']);
        }

        $book->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully!'
        ]);
    }

    // --- 12. DESTROY (Delete Book) ---
    public function destroy(Request $request, Book $book)
    {

        // Optional: Delete image from storage if needed
        // if($book->image) { Storage::delete('public/'.$book->image); }

        $book->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Book deleted successfully!'
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    // --- 13. GET BOOK DETAILS FOR MODAL (AJAX) ---
public function getBookDetails($id)
{
    // Book dhoondo
    $book = \App\Models\Book::with('category')->find($id);

    if (!$book) {
        return response()->json(['html' => '<p class="text-danger text-center">Book not found</p>']);
    }

    // Date Format (Agar date database me hai to)
    $date = $book->published_date ? date('d M, Y', strtotime($book->year)) : 'N/A';
    
    // Image Path
    $imagePath = asset('storage/'.$book->image);

    // 👇 Pura HTML Controller se bana kar bhej rahe hain (Premium Design)
    $html = '
        <div class="row g-4">
            <div class="col-md-5 text-center">
                <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="'.$imagePath.'" class="img-fluid" style="width: 100%; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-7">
                <span class="badge bg-success mb-2" style="font-size: 12px;">'.($book->category->name ?? 'General').'</span>
                
                <h3 style="font-weight: 700; color: #333;">'.$book->title.'</h3>
                <p class="text-muted mb-3">By <strong style="color: #015551;">'.$book->author.'</strong></p>

                <div class="d-flex align-items-center mb-4" style="gap: 15px; background: #f8f9fa; padding: 15px; border-radius: 10px;">
                    <h2 class="m-0" style="color: #FE4F2D; font-weight: 800;">$'.$book->price.'</h2>
                    <div style="height: 30px; width: 1px; background: #ddd;"></div>
                    <span class="text-success" style="font-weight: 600;"><i class="fas fa-check-circle"></i> Available</span>
                </div>

                <h6 style="font-weight: bold; color: #555;">Description</h6>
                <p style="color: #666; font-size: 14px; line-height: 1.6;">
                    '.$book->description.'
                </p>

                <hr>

                <div class="row mt-3">
                    <div class="col-6 mb-2">
                        <small class="text-muted d-block">Published Date</small>
                        <strong style="color: #333;"><i class="far fa-calendar-alt"></i> '.$date.'</strong>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted d-block">Publisher</small>
                        <strong style="color: #333;"><i class="far fa-building"></i> '.($book->publisher ?? 'LibraryPRO').'</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">ISBN</small>
                        <strong style="color: #333;">'.($book->isbn ?? 'N/A').'</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Pages</small>
                        <strong style="color: #333;">'.($book->pages ?? 'N/A').'</strong>
                    </div>
                </div>
            </div>
        </div>
    ';

    return response()->json(['html' => $html]);
}
public function faq()
{
    return view('pages.faq');

}       
}