

<!DOCTYPE html>
<html lang="en">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <title>Book CRUD</title>
</head>

<body>
    <header>
        {{-- <nav>
            <a href="{{ route('books.index') }}"><button>Books</button></a>
        </nav> --}}
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>
