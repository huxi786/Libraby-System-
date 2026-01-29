<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - LibraryPRO</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --primary: #015551;
            --accent: #FE4F2D;
            --light: #f4f7f6;
            --sidebar-w: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background: var(--light);
            min-height: 100vh;
            color: #333;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--primary);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            z-index: 1000;
            transition: 0.3s;
        }

        .sidebar-header {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
        }

        .sidebar-header span {
            color: var(--accent);
        }

        .nav-links {
            list-style: none;
            padding-top: 20px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
            border-left: 4px solid transparent;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid var(--accent);
        }

        .nav-links li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-w));
        }

        /* --- TOPBAR --- */
        .topbar {
            background: white;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-badge {
            background: var(--accent);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .logout-btn {
            background: #ffebee;
            color: #c62828;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* --- CONTENT BODY --- */
        .content-body {
            padding: 30px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Library<span>PRO</span></h2>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.welcome') }}"
                    class="{{ request()->routeIs('admin.welcome') ? 'active' : '' }}"><i
                        class="fas fa-tachometer-alt"></i> Home</a></li>
            <li><a href="{{ route('admin.requests') }}"
                    class="{{ request()->routeIs('admin.requests') ? 'active' : '' }}"><i
                        class="fas fa-clipboard-list"></i> Book Requests</a></li>
            <li><a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}"><i
                        class="fas fa-book"></i> Manage Books</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><i
                        class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="{{ route('admin.messages') }}"
                    class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}"><i class="fas fa-comments"></i>
                    User Support</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="page-title">Admin Command Center</div>
            <div class="user-profile">
                <span class="admin-badge">ADMIN</span>
                <span style="font-weight:600; color:#555;">{{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" class="logout-btn"><i class="fas fa-power-off"></i> Logout</a>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

</body>

</html>
