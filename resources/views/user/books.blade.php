@extends('layouts.user_layout')
@section('title', 'Browse Books')
{{-- Bootstrap CSS for Modal Styling --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')

    <style>
        /* --- PAGE HEADER --- */
        .page-header {
            background: linear-gradient(135deg, #015551, #003330);
            color: white;
            padding: 40px 20px 80px 20px;
            text-align: center;
            margin-bottom: 0;
        }

        .page-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .page-header p {
            opacity: 0.9;
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: 300;
        }

        /* --- CATEGORY FILTER BAR --- */
        .category-bar-container {
            max-width: 1200px;
            margin: -40px auto 40px auto;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .category-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            border: 1px solid #eee;
        }

        .cat-btn {
            text-decoration: none;
            color: #555;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cat-btn:hover {
            background: #f4f7f6;
            color: #015551;
        }

        .cat-btn.active {
            background: #015551;
            color: white;
            box-shadow: 0 4px 10px rgba(1, 85, 81, 0.3);
        }

        /* --- BOOKS CONTAINER --- */
        .books-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
            min-height: 60vh;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        /* --- BOOK CARD --- */
        .book-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(1, 85, 81, 0.15);
            border-color: #FE4F2D;
        }

        .book-image-box {
            height: 300px;
            width: 100%;
            background: #f4f4f4;
            position: relative;
            overflow: hidden;
        }

        .book-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-image-box img {
            transform: scale(1.08);
        }

        .cat-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 10px;
            font-size: 11px;
            border-radius: 20px;
            text-transform: uppercase;
            font-weight: bold;
            backdrop-filter: blur(4px);
        }

        .card-details {
            padding: 15px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 15px;
        }

        /* --- 🟢 UPDATED BUTTONS STYLING --- */
        .action-buttons {
            display: flex;
            gap: 10px;
            /* Space between buttons */
            margin-top: auto;
            /* Push buttons to bottom */
            width: 100%;
        }

        /* Common Style for Both Buttons */
        .btn-common {
            border: none;
            padding: 10px 0;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            width: 100%;
            /* Fill the container */
            height: 40px;
            /* Fixed height for uniformity */
        }

        /* 1. Request Button Style */
        .request-btn {
            background: #015551;
            color: white;
        }

        .request-btn:hover {
            background: #013f3e;
            color: white;
        }

        /* 2. View Button Style (Same Shape, Different Color) */
        .view-btn {
            background: #FE4F2D;
            /* Orange Accent Color */
            color: white;
        }

        .view-btn:hover {
            background: #d63c1e;
            color: white;
        }

        .admin-view-btn {
            background: #eee;
            color: #777;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: default;
        }

        .no-books {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 15px;
            border: 1px dashed #ccc;
        }

        /* --- MODAL FIX (Force Center) --- */
        .modal {
            background: rgba(0, 0, 0, 0.5);
            /* Dim background */
        }

        .modal-dialog {
            margin-top: 50px;
            /* Top spacing */
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1100px) {
            .books-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .books-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-bar {
                justify-content: flex-start;
                overflow-x: auto;
                white-space: nowrap;
                border-radius: 10px;
            }
        }

        @media (max-width: 480px) {
            .books-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            /* Stack buttons on mobile */
        }
    </style>

    <div class="page-header">
        <h2>Library Collection</h2>
        <p>Select a category below to filter books</p>
    </div>

    <div class="category-bar-container">
        <div class="category-bar">
            {{-- 'All' Button --}}
            <a href="{{ route('books.category', 'all') }}"
                class="cat-btn {{ isset($categoryName) && $categoryName == 'all' ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> All
            </a>

            {{-- Dynamic Categories --}}
            @foreach ($allCategories as $cat)
                <a href="{{ route('books.category', $cat->name) }}"
                    class="cat-btn {{ isset($categoryName) && $categoryName == $cat->name ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="books-container">
        <h3 style="margin-bottom: 25px; color: #333; font-weight: 700;">
            {{ isset($currentTitle) ? $currentTitle : (isset($title) ? $title : 'All Books') }}
        </h3>

        @if (session('success'))
            <div
                style="background:#d1e7dd; color:#0f5132; padding:15px; border-radius:10px; margin-bottom:30px; border:1px solid #badbcc;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                style="background:#f8d7da; color:#842029; padding:15px; border-radius:10px; margin-bottom:30px; border:1px solid #f5c2c7;">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="books-grid">
            @forelse($books as $book)
                <div class="book-card">
                    <div class="book-image-box">
                        <span class="cat-badge">{{ $book->category->name ?? 'General' }}</span>
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                            onerror="this.src='https://via.placeholder.com/300x400?text=No+Cover'">
                    </div>

                    <div class="card-details">
                        <div>
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <p class="book-author">by {{ $book->author }}</p>
                        </div>

                        @if (auth()->check() && auth()->user()->role !== 'admin')
                            {{-- 🟢 UPDATED ACTION BUTTONS --}}
                            <div class="action-buttons">

                                {{-- 1. Request Button --}}
                                <form action="{{ route('books.request', $book->id) }}" method="POST" style="flex:1;">
                                    @csrf
                                    <button type="submit" class="btn-common request-btn">Request</button>
                                </form>

                                {{-- 2. View Details Button --}}
                                <div style="flex:1;">
                                    <button type="button" class="btn-common view-btn view-book-btn"
                                        data-id="{{ $book->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>

                            </div>
                        @else
                            <div class="admin-view-btn"><i class="fas fa-shield-alt"></i> Admin View</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-books">
                    <i class="fas fa-search" style="font-size: 50px; margin-bottom: 20px; color: #ccc;"></i>
                    <h3 style="color:#555;">No books found</h3>
                    <p style="color:#777;">Please select a different category from above.</p>
                    <a href="{{ route('books.category', 'all') }}"
                        style="color: #015551; font-weight: bold; margin-top: 10px; display: inline-block;">View All
                        Books</a>
                </div>
            @endforelse
        </div>

        <div style="height: 60px;"></div>
    </div>

    {{-- 👇 QUICK VIEW MODAL 👇 --}}
    <div class="modal fade" id="bookViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="book-modal-content">
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                        <p class="mt-2">Loading details...</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 👇 AJAX SCRIPT 👇 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Ensure Bootstrap Bundle is loaded if not in layout --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.view-book-btn').on('click', function() {
                let bookId = $(this).data('id');

                $('#book-modal-content').html(`
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                        <p class="mt-2">Loading...</p>
                    </div>
                `);
                $('#bookViewModal').modal('show');

                $.ajax({
                    url: '/book/details/' + bookId,
                    type: 'GET',
                    success: function(response) {
                        $('#book-modal-content').html(response.html);
                    },
                    error: function() {
                        $('#book-modal-content').html(
                            '<p class="text-danger text-center">Something went wrong!</p>');
                    }
                });
            });
        });
    </script>

@endsection
