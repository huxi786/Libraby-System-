@extends('layouts.admin_layout')
@include('partials.header')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="container my-5">

        <div class="page-header" style="justify-content: center; margin-bottom: 40px;">
            <h1 class="page-title">Edit Book Details</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                
                @if ($errors->any())
                    <div class="custom-alert" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-container">
                    {{-- NOTE: enctype zaroori hai image upload ke liye --}}
                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. TITLE --}}
                        <div class="mb-4">
                            <label for="title" class="form-label"><i class="fas fa-heading"></i> Book Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $book->title) }}" required placeholder="Enter book name">
                        </div>

                        {{-- 2. AUTHOR --}}
                        <div class="mb-4">
                            <label for="author" class="form-label"><i class="fas fa-user-edit"></i> Author Name</label>
                            <input type="text" name="author" class="form-control" id="author" value="{{ old('author', $book->author) }}" required placeholder="Author name">
                        </div>

                        {{-- 3. CATEGORY (NEW ADDED) --}}
                        <div class="mb-4">
                            <label for="category_id" class="form-label"><i class="fas fa-list"></i> Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (old('category_id', $book->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            {{-- 4. YEAR --}}
                            <div class="col-md-6 mb-4">
                                <label for="year" class="form-label"><i class="fas fa-calendar-alt"></i> Publish Year</label>
                                <input type="number" name="year" class="form-control" id="year" value="{{ old('year', $book->year) }}" placeholder="e.g. 2023">
                            </div>

                            {{-- 5. PRICE --}}
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label"><i class="fas fa-tag"></i> Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price', $book->price) }}" required placeholder="0.00">
                            </div>
                        </div>

                        {{-- 6. IMAGE UPLOAD (NEW ADDED) --}}
                        <div class="mb-4">
                            <label for="image" class="form-label"><i class="fas fa-image"></i> Update Book Cover (Optional)</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            
                            {{-- Agar pehle se image hai to dikhayein --}}
                            @if($book->image)
                                <div style="margin-top: 10px;">
                                    <small style="color: #666;">Current Image:</small><br>
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="Current Cover" style="height: 60px; border-radius: 5px; border: 1px solid #ddd;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('books.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Update Book
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection