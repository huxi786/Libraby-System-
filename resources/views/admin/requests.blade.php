@extends('layouts.admin_layout')

@section('content')
    <style>
        /* --- STYLES (SAME AS BEFORE) --- */
        .page-wrapper {
            background: #f8f9fa;
            min-height: 80vh;
            padding: 40px 20px;
            font-family: 'Poppins', sans-serif;
        }

        .request-card {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: #015551;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #FE4F2D;
        }

        .card-title {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-count {
            background: #FE4F2D;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }

        .styled-table thead tr {
            background-color: #f1f3f5;
            color: #333;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .user-info {
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #e0f2f1;
            color: #015551;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .book-title {
            color: #555;
            font-style: italic;
        }

        .date-badge {
            background: #eef2f7;
            color: #555;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
        }

        /* ACTION BUTTONS (Converted to Links style) */
        .btn-action {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.3s;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-approve {
            background-color: #e6fffa;
            color: #00796b;
            border-color: #b2dfdb;
        }

        .btn-approve:hover {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .btn-reject {
            background-color: #ffebee;
            color: #c62828;
            border-color: #ffcdd2;
            margin-left: 5px;
        }

        .btn-reject:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 15px;
            color: #ccc;
        }
    </style>

    <div class="page-wrapper">

        {{-- Flash Messages (Standard Session) --}}
        @if (session('success'))
            <div
                style="max-width: 1100px; margin: 0 auto 20px auto; background: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 10px; text-align: center;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="max-width: 1100px; margin: 0 auto 20px auto; background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; text-align: center;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="request-card">
            <div class="card-header">
                <h2 class="card-title">
                    📄 Pending Requests
                </h2>

                @if ($requests->count() > 0)
                    <span class="badge-count">{{ $requests->count() }} New</span>
                @endif
            </div>

            <div class="card-body">
                @if ($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th width="25%">User Name</th>
                                    <th width="35%">Book Title</th>
                                    <th width="15%">Requested On</th>
                                    <th width="25%" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $req)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($req->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                {{ $req->user->name ?? 'Unknown User' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="book-title">📖 {{ $req->book->title ?? 'Unknown Book' }}</span>
                                        </td>
                                        <td>
                                            <span class="date-badge">📅 {{ $req->created_at->format('d M, Y') }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            {{-- ✅ STANDARD LINKS (NO AJAX) --}}

                                            {{-- Approve --}}
                                            <a href="{{ route('admin.issue.approve', $req->id) }}"
                                                class="btn-action btn-approve">
                                                ✅ Approve
                                            </a>

                                            {{-- Reject --}}
                                            <a href="{{ route('admin.issue.reject', $req->id) }}"
                                                class="btn-action btn-reject"
                                                onclick="return confirm('Are you sure you want to REJECT this request?');">
                                                ❌ Reject
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="empty-state">
                        <div class="empty-icon">🎉</div>
                        <h3 style="color: #555;">All Caught Up!</h3>
                        <p style="color: #888;">No pending book requests at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
