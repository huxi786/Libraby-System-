@extends('layouts.admin_layout')

@section('content')

<style>
    .book-detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        max-width: 900px;
        margin: 40px auto;
        border: 1px solid #eee;
    }

    .book-image-section {
        width: 40%;
        background: #f4f7f6;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        border-right: 1px solid #eee;
    }

    .detail-img {
        width: 100%;
        max-width: 250px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        border-radius: 10px;
        transform: rotate(-3deg);
        transition: 0.3s;
    }
    .detail-img:hover { transform: rotate(0); }

    .book-info-section {
        width: 60%;
        padding: 40px;
    }

    .b-title { color: #015551; font-weight: 800; font-size: 32px; margin-bottom: 5px; line-height: 1.2; }
    .b-author { color: #777; font-size: 18px; margin-bottom: 20px; font-weight: 500; }
    
    .info-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        margin-bottom: 30px;
    }
    .info-box label { font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; display: block; margin-bottom: 5px; }
    .info-box span { font-size: 16px; color: #333; font-weight: 600; }

    .price-tag {
        display: inline-block;
        background: #e0f2f1; color: #00695c;
        padding: 8px 20px; border-radius: 30px;
        font-weight: 800; font-size: 20px;
    }

    .action-buttons { margin-top: 30px; display: flex; gap: 15px; }

    .btn-edit { background: #FE4F2D; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; transition: 0.3s; }
    .btn-edit:hover { background: #d63c1f; color: white; transform: translateY(-2px); }

    .btn-back { background: #eee; color: #555; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; }
    .btn-back:hover { background: #ddd; color: #333; }

    /* Responsive */
    @media (max-width: 768px) {
        .book-detail-card { flex-direction: column; }
        .book-image-section, .book-info-section { width: 100%; }
        .detail-img { transform: rotate(0); max-width: 180px; }
    }
</style>

<div class="container">
    
    <div class="book-detail-card">
        
        <div class="book-image-section">
            @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="detail-img">
            @else
                <div style="width: 200px; height: 300px; background: #ddd; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: #777;">
                    <i class="fas fa-book" style="font-size: 60px;"></i>
                </div>
            @endif
        </div>

        <div class="book-info-section">
            <h1 class="b-title">{{ $book->title }}</h1>
            <p class="b-author">by {{ $book->author }}</p>

            <div class="info-grid">
                <div class="info-box">
                    <label>Category</label>
                    <span style="color: #015551;">{{ $book->category->name ?? 'Uncategorized' }}</span>
                </div>
                <div class="info-box">
                    <label>Published Year</label>
                    <span>{{ $book->year ?? 'N/A' }}</span>
                </div>
                <div class="info-box">
                    <label>Added On</label>
                    <span>{{ $book->created_at->format('M d, Y') }}</span>
                </div>
                <div class="info-box">
                    <label>Price</label>
                    <span class="price-tag">${{ number_format($book->price, 2) }}</span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('books.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                
                {{-- Edit Button (Sirf Admin ke liye) --}}
                <a href="{{ route('books.edit', $book->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Book
                </a>
            </div>

        </div>

    </div>
</div>

@endsection