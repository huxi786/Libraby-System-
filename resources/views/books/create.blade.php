@extends('layouts.admin_layout')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Add New Book</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST" class="p-4 shadow rounded bg-white">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Book title"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" id="author" placeholder="Author name"
                            required>
                    </div>

                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach 
                    </select>

                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" id="year"
                            placeholder="Publication year">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="price" placeholder="Book price">

                        <div class="text-end">
                            <a href="{{ route('books.index') }}" class="btn btn-secondary me-2">Back</a>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
