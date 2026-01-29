<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Library</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    @php
        // FIX: 'Issue' model ki jagah 'Borrow' use kiya (Status Pending count ke liye)
        // Try-catch lagaya taake agar table na ho to error na aye
        try {
            $pendingCount = \App\Models\Borrow::where('status', 'pending')->count();
        } catch (\Exception $e) {
            $pendingCount = 0;
        }
    @endphp

    <div class="sidebar">
        <div class="brand">
            Library<span style="color: #fc5c2b">PRO</span>
        </div>

        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span><i class="fas fa-th-large"></i> Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <span><i class="fas fa-book"></i> Manage Books</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.requests') }}" class="{{ request()->routeIs('admin.requests') ? 'active' : '' }}">
                    <span><i class="fas fa-hand-holding"></i> Issue Requests</span>

                    @if (isset($pendingCount) && $pendingCount > 0)
                        <span
                            style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 50%; font-size: 12px; margin-left: 10px; font-weight:bold;">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span><i class="fas fa-users"></i> Users List</span>

                    @php
                        // Pending Users Count
                        $pendingUserCount = 0;
                        try {
                             // Role check hata diya agar column nahi hai database me
                            $pendingUserCount = \App\Models\User::where('status', 'pending')->count();
                        } catch (\Exception $e) {}
                    @endphp

                    @if ($pendingUserCount > 0)
                        <span style="background: #ffc107; color: #333; padding: 2px 8px; border-radius: 50%; font-size: 12px; margin-left: 10px; font-weight:bold;">
                            {{ $pendingUserCount }}
                        </span>
                    @endif
                </a>
            </li>

            <li>
                <a href="{{ route('admin.welcome') }}">
                    <span><i class="fas fa-home"></i> Back to Home</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span><i class="fas fa-sign-out-alt"></i> Logout</span>
                </a>
                
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>

    <div class="main-content">

        <header class="top-navbar">
            <h2>@yield('header-title', 'Dashboard')</h2>

            <div class="user-profile">
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=015551&color=fff"
                    alt="Admin">
            </div>
        </header>

        <div class="page-content">
            @yield('content')
        </div>

    </div>

</body>

</html>