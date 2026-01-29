@extends('layouts.admin_layout')

@section('header-title', 'Manage Users')

@section('content')

    {{-- CSS: Sirf Scrollbar rakha hai, Blink effect hata diya --}}
    <style>
        /* 🟢 CUSTOM SCROLLBAR STYLES  */
        .table-scroller::-webkit-scrollbar {
            width: 8px;
        }

        .table-scroller::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-scroller::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .table-scroller::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>

    {{-- ✅ PHP SESSION MESSAGES (AJAX ki jagah ab ye chalenge) --}}
    @if (session('success'))
        <div
            style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif


    {{-- TABLE 1: PENDING USERS --}}
    <div
        style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; border-left: 5px solid #dc3545;">

        <h3 style="color: #dc3545; margin-bottom: 20px;">⏳ Pending Login Requests</h3>

        @if ($pendingUsers->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; text-align: left;">
                        <th style="padding: 10px;">Name</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Joined</th>
                        <th style="padding: 10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingUsers as $user)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px; font-weight: bold;">{{ $user->name }}</td>
                            <td style="padding: 10px;">{{ $user->email }}</td>
                            <td style="padding: 10px; color: #777;">{{ $user->created_at->diffForHumans() }}</td>
                            <td style="padding: 10px; display:flex; gap:5px;">

                                {{-- ✅ APPROVE BUTTON (Standard Link) --}}
                                <a href="{{ route('admin.user.approve', $user->id) }}"
                                    style="background: #28a745; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px;">
                                    <i class="fas fa-check"></i> Approve
                                </a>

                                {{-- ✅ DELETE BUTTON (Form Submission) --}}
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: #dc3545; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; font-size: 13px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #888;">No pending requests at the moment.</p>
        @endif
    </div>


    {{-- TABLE 2: ACTIVE USERS --}}
    <div
        style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #28a745;">

        <h3 style="color: #015551; margin-bottom: 20px;">✅ All Active Users</h3>

        <div class="table-scroller" style="max-height: 450px; overflow-y: auto; display: block; border: 1px solid #eee;">
            @if ($activeUsers->count() > 0)
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; text-align: left;">
                            <th
                                style="padding: 10px; position: sticky; top: 0; background: #f8f9fa; z-index: 2; border-bottom: 2px solid #ddd;">
                                Name</th>
                            <th
                                style="padding: 10px; position: sticky; top: 0; background: #f8f9fa; z-index: 2; border-bottom: 2px solid #ddd;">
                                Email</th>
                            <th
                                style="padding: 10px; position: sticky; top: 0; background: #f8f9fa; z-index: 2; border-bottom: 2px solid #ddd;">
                                Status</th>
                            <th
                                style="padding: 10px; position: sticky; top: 0; background: #f8f9fa; z-index: 2; border-bottom: 2px solid #ddd;">
                                Role</th>
                            <th
                                style="padding: 10px; position: sticky; top: 0; background: #f8f9fa; z-index: 2; border-bottom: 2px solid #ddd;">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeUsers as $user)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px; font-weight: bold;">{{ $user->name }}</td>
                                <td style="padding: 10px;">{{ $user->email }}</td>
                                <td style="padding: 10px;">
                                    <span
                                        style="background: #d4edda; color: #155724; padding: 3px 8px; border-radius: 10px; font-size: 12px; font-weight: bold;">Active</span>
                                </td>
                                <td style="padding: 10px; text-transform: capitalize;">
                                    @if ($user->role == 'admin' || $user->is_admin == 1)
                                        <span
                                            style="color: #dc3545; font-weight: bold; background: #ffe5e5; padding: 2px 8px; border-radius: 4px;">Admin</span>
                                    @else
                                        User
                                    @endif
                                </td>
                                <td style="padding: 10px;">
                                    {{-- ✅ DELETE BUTTON (Form Submission) --}}
                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to remove this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background: #ffe5e5; color: #dc3545; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; font-size: 13px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 20px;">
                    <p style="color: #888;">No active users found.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ❌ SCRIPT SECTION REMOVED COMPLETELY --}}

@endsection
