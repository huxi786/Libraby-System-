@extends('layouts.admin_layout')

@section('content')

<div class="container mt-4">

    <h2>All Books</h2>

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>ISBN</th>
                <th>Qty</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name ?? 'N/A' }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->quantity }}</td>

                <td>
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('books.delete', $book->id) }}" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection
