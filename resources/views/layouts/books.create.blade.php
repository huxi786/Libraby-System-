{{-- @extends('layout')

@section('content')

<div class="container mt-4">

    <h2>Add New Book</h2>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Book Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Author Name</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>

                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>ISBN Number</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <button class="btn btn-success">Save Book</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>

@endsection --}}
