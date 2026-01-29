@extends('layouts.admin_layout')

@section('content')
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">

    {{-- Container --}}
    <div class="container my-5" style="font-family: 'Poppins', sans-serif;">

        {{-- Header --}}
        <div class="page-header"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
            <h1 class="page-title" style="color: #015551; font-weight: 700; margin: 0;">📚 Manage Library Books</h1>

            <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addBookModal"
                style="background: #FE4F2D; color: white; padding: 10px 20px; border: none; border-radius: 30px; font-weight: 600; box-shadow: 0 4px 10px rgba(254, 79, 45, 0.3); transition: 0.3s; cursor: pointer;">
                <i class="fas fa-plus"></i> Add New Book
            </button>
        </div>

        {{-- Success Message --}}
        <div id="success-msg" class="custom-alert"
            style="display:none; background: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 10px; margin-bottom: 20px; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i> <span id="msg-text"></span>
        </div>

        {{-- Table --}}
        <div class="table-container"
            style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <div class="table-responsive">
                <table class="custom-table" style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                        <tr>
                            <th style="padding: 15px; text-align: left; color: #555;">No.</th>
                            <th style="padding: 15px; text-align: left; color: #555;">Book Title</th>
                            <th style="padding: 15px; text-align: left; color: #555;">Author</th>
                            <th style="padding: 15px; text-align: center; color: #555;">Category</th>
                            <th style="padding: 15px; text-align: center; color: #555;">Price</th>
                            <th style="padding: 15px; text-align: center; color: #555;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="books_table_body">
                        {{-- AJAX Data --}}
                    </tbody>
                </table>
            </div>
            {{-- Empty State --}}
            <div id="empty-state" style="display:none; text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-book-open" style="font-size: 40px; margin-bottom: 10px; opacity: 0.5;"></i>
                <p>No books found in the library.</p>
            </div>
        </div>
    </div>

    {{-- ========================== --}}
    {{-- 🟢 MODAL 1: ADD NEW BOOK --}}
    {{-- ========================== --}}
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #015551; color: white;">
                    <h5 class="modal-title">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: white; border:none; color:white;">X</button>
                </div>
                <form id="addBookForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <ul id="save_msgList" style="display:none;" class="alert alert-danger"></ul>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Book Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Year</label>
                                <input type="number" name="year" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Cover Image (Optional)</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background: #015551; border:none;">Save
                            Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================== --}}
    {{-- 🟢 MODAL 2: EDIT BOOK --}}
    {{-- ========================== --}}
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #f59e0b; color: white;">
                    <h5 class="modal-title">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: white; border:none; color:white;">X</button>
                </div>

                <form id="editBookForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <ul id="update_msgList" style="display:none;" class="alert alert-danger"></ul>

                        <input type="hidden" id="edit_book_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Book Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" id="edit_author" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" id="edit_category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Year</label>
                                <input type="number" name="year" id="edit_year" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" id="edit_price"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">New Cover Image (Optional)</label>
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background: #f59e0b; border:none;">Update
                            Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================== --}}
    {{-- 🟢 MODAL 3: VIEW BOOK (NEW) --}}
    {{-- ========================== --}}
    <div class="modal fade" id="viewBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #e0f2f1; color: #00695c;">
                    <h5 class="modal-title">📖 Book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center; margin-bottom: 20px;">
                        {{-- Image yahan aayegi --}}
                        <img id="view_image" src="" alt="Book Cover"
                            style="width: 150px; height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display:none;">
                        <br>
                        <div id="no_image_text" style="display:none; color:#999; margin-top:10px;">No Cover Image</div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%; background: #f9f9f9;">Title</th>
                            <td><span id="view_title" style="font-weight: bold; color: #333;"></span></td>
                        </tr>
                        <tr>
                            <th style="background: #f9f9f9;">Author</th>
                            <td><span id="view_author"></span></td>
                        </tr>
                        <tr>
                            <th style="background: #f9f9f9;">Category</th>
                            <td><span id="view_category" class="badge bg-success"></span></td>
                        </tr>
                        <tr>
                            <th style="background: #f9f9f9;">Price</th>
                            <td>$<span id="view_price"></span></td>
                        </tr>
                        <tr>
                            <th style="background: #f9f9f9;">Year</th>
                            <td><span id="view_year"></span></td>
                        </tr>
                        <tr>
                            <th style="background: #f9f9f9;">Status</th>
                            <td><span id="view_status" class="badge bg-secondary"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Scripts --}}
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            window.location.href = "{{ route('admin.welcome') }}";
        };
    </script>
    
    {{-- ✅ FIX: Yahan se JQuery aur Bootstrap ke Script tags HATA DIYE hain kyunki wo Layout me hain --}}

    {{-- FULL AJAX SCRIPT --}}
    <script>
        //-- DOCUMENT READY ---
        $(document).ready(function() {
            // Initial Fetch
            fetchBooks();

            // --- FUNCTION 1: FETCH BOOKS ---
            function fetchBooks() {
                $.ajax({
                    url: "{{ route('books.index') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#books_table_body').html('');
                        $('#empty-state').hide();
                        if (response.data.length === 0) {
                            $('#empty-state').show();
                        } else {
                            $.each(response.data, function(key, book) {
                                let catName = book.category ? book.category.name : 'N/A';
                                let serialNo = key + 1;

                                let row = `
                                    <tr style="border-bottom: 1px solid #f0f0f0; transition: 0.2s;">
                                        <td style="padding: 15px; color: #999; font-weight: bold;">${serialNo}</td>
                                        <td style="padding: 15px;">
                                            <span style="display: block; font-weight: 600; color: #333; font-size: 15px;">${book.title}</span>
                                            <small style="color: #999;">${book.year ? book.year : ''}</small>
                                        </td>
                                        <td style="padding: 15px; color: #666;">${book.author}</td>
                                        <td style="padding: 15px; text-align: center;">
                                            <span style="background: #e0f2f1; color: #00695c; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">${catName}</span>
                                        </td>
                                        <td style="padding: 15px; text-align: center;">
                                            <span style="font-weight: 700; color: #015551;">$${Number(book.price).toFixed(2)}</span>
                                        </td>
                                        <td style="padding: 15px; text-align: center;">
                                            <div class="action-box" style="display: flex; justify-content: center; gap: 8px;">
                                                
                                                {{-- 🟢 UPDATED: VIEW BUTTON (Opens Modal) --}}
                                                <button class="btn-icon view-btn" data-id="${book.id}" style="color: #015551; background: #e0f2f1; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: none; cursor: pointer;">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <button class="btn-icon edit-btn" data-id="${book.id}" style="color: #f59e0b; background: #fff3e0; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border:none; cursor:pointer;">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                <button class="btn-icon delete-btn" data-id="${book.id}" style="color: #dc3545; background: #ffe5e5; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                $('#books_table_body').append(row);
                            });
                        }
                    }
                });
            }

            // --- FUNCTION 2: CREATE NEW BOOK ---
            $(document).on('submit', '#addBookForm', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('books.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addBookModal').modal('hide');
                            $('#addBookForm')[0].reset();
                            fetchBooks();
                            // Optional Cleanup (Backup)
                            setTimeout(function() {
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open').css('overflow',
                                    'auto').css('padding-right', '0');
                            }, 300);
                            $('#msg-text').text(response.message);
                            $('#success-msg').fadeIn().delay(3000).fadeOut();
                            $('#save_msgList').html("").hide();
                        }
                    },
                    error: function(xhr) {
                        $('#save_msgList').html("").show();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, error_values) {
                                $('#save_msgList').append('<li>' + error_values +
                                    '</li>');
                            });
                        }
                    }
                });
            });

            // --- FUNCTION 3: DELETE BOOK ---
            $(document).on('click', '.delete-btn', function() {
                let bookId = $(this).data('id');
                let row = $(this).closest('tr');
                if (confirm("Are you really sure?")) {
                    $.ajax({
                        url: "/admin/books/" + bookId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            row.fadeOut(500, function() {
                                $(this).remove();
                                fetchBooks();
                            });
                            $('#msg-text').text(response.message);
                            $('#success-msg').fadeIn().delay(3000).fadeOut();
                        }
                    });
                }
            });

            // --- FUNCTION 4: EDIT BOOK (OPEN MODAL) ---
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                let bookId = $(this).data('id');
                $('#update_msgList').html("").hide();

                $.ajax({
                    url: "/admin/books/" + bookId + "/edit",
                    type: "GET",
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#edit_book_id').val(response.book.id);
                            $('#edit_title').val(response.book.title);
                            $('#edit_author').val(response.book.author);
                            $('#edit_year').val(response.book.year);
                            $('#edit_price').val(response.book.price);
                            $('#edit_category_id').val(response.book.category_id);
                            $('#editBookModal').modal('show');
                        } else {
                            alert("Book not found!");
                        }
                    }
                });
            });

            // --- FUNCTION 5: UPDATE BOOK ---
            $(document).on('submit', '#editBookForm', function(e) {
                e.preventDefault();
                let bookId = $('#edit_book_id').val();
                let formData = new FormData(this);
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('_method', 'PUT');

                $.ajax({
                    url: "/admin/books/" + bookId,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#editBookModal').modal('hide');
                            $('#editBookForm')[0].reset();
                            fetchBooks();
                            setTimeout(function() {
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open').css('overflow',
                                    'auto').css('padding-right', '0');
                            }, 300);
                            $('#msg-text').text(response.message);
                            $('#success-msg').fadeIn().delay(3000).fadeOut();
                            $('#update_msgList').html("").hide();
                        }
                    },
                    error: function(xhr) {
                        $('#update_msgList').html("").show();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, error_values) {
                                $('#update_msgList').append('<li>' + error_values +
                                    '</li>');
                            });
                        }
                    }
                });
            });

            // --- 🟢 FUNCTION 6: VIEW BOOK (NEW) ---
            $(document).on('click', '.view-btn', function(e) {
                e.preventDefault();
                let bookId = $(this).data('id');

                $.ajax({
                    url: "/admin/books/" + bookId, // Show URL
                    type: "GET",
                    success: function(response) {
                        if (response.status == 'success') {
                            let book = response.book;

                            // Text Fields Bharein
                            $('#view_title').text(book.title);
                            $('#view_author').text(book.author);
                            $('#view_price').text(book.price);
                            $('#view_year').text(book.year ? book.year : 'N/A');
                            $('#view_category').text(book.category ? book.category.name :
                                'N/A');
                            $('#view_status').text(book.status);

                            // Image Logic
                            if (book.image) {
                                $('#view_image').attr('src', '/storage/' + book.image).show();
                                $('#no_image_text').hide();
                            } else {
                                $('#view_image').hide();
                                $('#no_image_text').show();
                            }

                            // Modal Open Karein
                            $('#viewBookModal').modal('show');
                        }
                    }
                });
            });

        });
    </script>
@endsection