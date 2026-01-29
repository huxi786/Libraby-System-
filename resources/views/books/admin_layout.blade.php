<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - LibraryPRO</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #015551;
            /* Deep Teal */
            --primary-dark: #013f3e;
            --accent: #FE4F2D;
            /* Orange */
            --bg-color: #f4f7f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
        }

        /* --- ADMIN HEADER STYLE --- */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid #eee;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--primary);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        /* Admin Navigation Pills */
        .admin-nav {
            display: flex;
            gap: 10px;
            background: #f0f2f5;
            padding: 5px;
            border-radius: 50px;
        }

        .nav-item {
            text-decoration: none;
            color: #666;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-item:hover {
            color: var(--primary);
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .nav-item.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(1, 85, 81, 0.3);
        }

        /* Admin Profile Area */
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .badge-role {
            background: #ffe0b2;
            color: #e65100;
            font-size: 11px;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .logout-btn {
            background: #ffebee;
            color: #c62828;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #c62828;
            color: white;
            transform: rotate(90deg);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .admin-header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <header class="admin-header">

        <a href="{{ route('admin.welcome') }}" class="brand-logo">
            <i class="fas fa-shield-alt"></i> ADMIN PANEL
        </a>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <a href="{{ route('books.index') }}" class="nav-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Manage Books
            </a>

            <a href="{{ route('admin.users') }}"
                class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>

            <a href="{{ route('admin.requests') }}"
                class="nav-item {{ request()->routeIs('admin.requests') ? 'active' : '' }}">
                <i class="fas fa-hand-holding"></i> Requests
            </a>

            <a href="{{ route('admin.messages') }}"
                class="nav-item {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Inbox
            </a>
        </nav>

        <div class="admin-profile">
            <span class="badge-role">Super Admin</span>
            <div style="text-align: right; line-height: 1.2;">
                <span
                    style="font-weight: 700; display: block; font-size: 14px; color: #333;">{{ Auth::user()->name }}</span>
            </div>

            <a href="{{ route('logout') }}" class="logout-btn" title="Logout"
                onclick="return confirm('Are you sure you want to log out?');">

                <i class="fas fa-power-off"></i>
            </a>
        </div>

    </header>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
