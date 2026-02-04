<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LibraryPRO')</title>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* --- 🎨 THEME VARIABLES --- */
        :root {
            /* Light Mode */
            --bg-body: #f0f2f5;
            --bg-glass: rgba(255, 255, 255, 0.85);
            /* Glass Effect */
            --bg-card: #ffffff;
            --text-main: #2d3436;
            --text-muted: #636e72;
            --border-color: #e2e8f0;
            --primary: #015551;
            --primary-glow: rgba(1, 85, 81, 0.3);
            --accent: #FE4F2D;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        [data-theme="dark"] {
            /* Dark Mode */
            --bg-body: #0f172a;
            --bg-glass: rgba(30, 41, 59, 0.85);
            /* Dark Glass */
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --primary: #2dd4bf;
            --primary-glow: rgba(45, 212, 191, 0.3);
            --accent: #f472b6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* --- GLOBAL SMOOTHNESS --- */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        main {
            width: 100%;
            display: block;
        }

        /* --- ✨ GLASS NAVBAR --- */
        .navbar {
            background: var(--bg-glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.4s ease;
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .desktop-nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        /* Animated Links */
        .nav-link {
            color: var(--text-main);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            position: relative;
            padding: 5px 0;
            transition: 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 0;
            background: var(--primary);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        /* --- ☀️/🌑 PRO TOGGLE SWITCH --- */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
        }

        .theme-switch {
            display: inline-block;
            height: 26px;
            position: relative;
            width: 50px;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #ccc;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            background-color: white;
            bottom: 3px;
            content: "";
            height: 20px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 20px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .slider .icon-sun,
        .slider .icon-moon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            transition: 0.4s;
        }

        .slider .icon-sun {
            left: 7px;
            color: #f39c12;
            opacity: 1;
        }

        .slider .icon-moon {
            right: 7px;
            color: #f1c40f;
            opacity: 0;
        }

        input:checked+.slider {
            background-color: var(--primary);
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        input:checked+.slider .icon-sun {
            opacity: 0;
        }

        input:checked+.slider .icon-moon {
            opacity: 1;
        }

        /* --- 👤 PROFILE DROPDOWN (Animated) --- */
        .profile-container {
            position: relative;
            cursor: pointer;
            margin-left: 15px;
        }

        .profile-btn {
            background: var(--bg-card);
            padding: 8px 15px;
            border-radius: 50px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            transition: 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-btn:hover {
            border-color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .desktop-dropdown {
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            position: absolute;
            top: 130%;
            right: 0;
            width: 220px;
            background: var(--bg-card);
            border-radius: 15px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            padding: 10px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 1001;
        }

        .desktop-dropdown::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: var(--bg-card);
            transform: rotate(45deg);
            border-top: 1px solid var(--border-color);
            border-left: 1px solid var(--border-color);
        }

        .profile-container:hover .desktop-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dd-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.2s;
            font-weight: 500;
        }

        .dd-item:hover {
            background: var(--bg-body);
            color: var(--primary);
        }

        .dd-logout {
            color: #e74c3c !important;
        }

        .dd-logout:hover {
            background: #ffe5e5;
        }

        /* --- 🌍 GLOBAL CLASSES --- */
        .content-box {
            background: var(--bg-card);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            max-width: 1000px;
            margin: 40px auto;
            transition: 0.3s;
        }

        .input-std {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            outline: none;
            transition: 0.3s;
        }

        .input-std:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* --- 📱 MOBILE --- */
        .burger-menu {
            display: none;
        }

        .mobile-overlay {
            display: none;
        }

        .nav-drawer {
            display: none;
        }

        @media (max-width: 900px) {
            .navbar {
                padding: 15px 20px;
            }

            .desktop-nav {
                display: none;
            }

            .burger-menu {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--text-main);
                cursor: pointer;
                padding: 8px 12px;
                border-radius: 8px;
                background: var(--bg-body);
            }

            .mobile-overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(5px);
                z-index: 1999;
                opacity: 0;
                visibility: hidden;
                transition: 0.3s ease;
            }

            .mobile-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .nav-drawer {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0;
                right: -300px;
                width: 280px;
                height: 100vh;
                background: var(--bg-card);
                z-index: 2000;
                transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                padding: 25px;
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0.2);
                overflow-y: auto;
            }

            .nav-drawer.active {
                right: 0;
            }

            .drawer-item {
                color: var(--text-main);
                text-decoration: none;
                padding: 15px;
                font-size: 16px;
                display: flex;
                align-items: center;
                gap: 15px;
                border-radius: 12px;
                margin-bottom: 5px;
                font-weight: 500;
            }

            .drawer-item:hover,
            .drawer-item.active {
                background: var(--primary);
                color: white;
            }

            .mobile-theme-box {
                margin-top: 20px;
                padding: 15px;
                background: var(--bg-body);
                border-radius: 12px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: var(--text-main);
                font-weight: 600;
            }
        }
    </style>
</head>

<body>

    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleMenu()"></div>

    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">LibraryPRO</a>

        <div class="desktop-nav">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            @auth <a href="{{ route('user.dashboard') }}"
                class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a> @endauth
            <a href="{{ route('books.category', 'all') }}"
                class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">Browse</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}"
                class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>

            <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" onchange="toggleTheme(this)">
                    <div class="slider">
                        <i class="fas fa-sun icon-sun"></i>
                        <i class="fas fa-moon icon-moon"></i>
                    </div>
                </label>
            </div>

            @auth
                <div class="profile-container">
                    <div class="profile-btn">
                        <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <i class="fas fa-chevron-down" style="font-size:10px; opacity:0.6;"></i>
                    </div>
                    <div class="desktop-dropdown">
                        <div
                            style="padding: 10px 15px; font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">
                            Account</div>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('books.create') }}" class="dd-item"><i class="fas fa-plus-circle"></i> Add
                                Book</a>
                        @endif
                        <a href="{{ route('user.dashboard') }}" class="dd-item"><i class="fas fa-chart-pie"></i>
                            Dashboard</a>
                        <div style="height:1px; background:var(--border-color); margin:5px 0;"></div>
                        <a href="#" onclick="confirmLogout()" class="dd-item dd-logout"><i
                                class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link"
                    style="background:var(--primary); color:white !important; padding:8px 25px; border-radius:50px; box-shadow:0 4px 10px var(--primary-glow);">Login</a>
            @endauth
        </div>

        <div class="burger-menu" onclick="toggleMenu()">
            <i class="fas fa-bars" style="font-size: 20px;"></i>
        </div>
    </nav>

    <div class="nav-drawer" id="navDrawer">
        <div style="display:flex; justify-content:space-between; margin-bottom:30px; align-items:center;">
            <span class="logo" style="font-size: 22px;">LibraryPRO</span>
            <div style="background:var(--bg-body); width:35px; height:35px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;"
                onclick="toggleMenu()">
                <i class="fas fa-times" style="color:var(--text-main);"></i>
            </div>
        </div>

        <a href="{{ route('home') }}" class="drawer-item {{ request()->routeIs('home') ? 'active' : '' }}"><i
                class="fas fa-home"></i> Home</a>
        @auth <a href="{{ route('user.dashboard') }}"
                class="drawer-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i
                class="fas fa-chart-pie"></i> Dashboard</a> @endauth
        <a href="{{ route('books.category', 'all') }}"
            class="drawer-item {{ request()->routeIs('books.*') ? 'active' : '' }}"><i class="fas fa-book"></i>
            Browse</a>
        <a href="{{ route('about') }}" class="drawer-item {{ request()->routeIs('about') ? 'active' : '' }}"><i
                class="fas fa-info-circle"></i> About</a>
        <a href="{{ route('contact') }}" class="drawer-item {{ request()->routeIs('contact') ? 'active' : '' }}"><i
                class="fas fa-envelope"></i> Contact</a>

        <div class="mobile-theme-box">
            <span>Appearance</span>
            <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox-mobile">
                    <input type="checkbox" id="checkbox-mobile" onchange="toggleTheme(this)">
                    <div class="slider">
                        <i class="fas fa-sun icon-sun"></i>
                        <i class="fas fa-moon icon-moon"></i>
                    </div>
                </label>
            </div>
        </div>

        @auth
            <a href="#" onclick="confirmLogout()" class="drawer-item" style="color:#e74c3c; margin-top:auto;"><i
                    class="fas fa-sign-out-alt"></i> Logout</a>
        @else
            <a href="{{ route('login') }}" class="drawer-item" style="color:var(--primary); font-weight:700;"><i
                    class="fas fa-sign-in-alt"></i> Login</a>
        @endauth
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    <main style="flex:1; width:100%; overflow-x:hidden;">
        @yield('content')
    </main>

    {{-- ✅ FIXED: Using Partial Footer Only --}}
    @include('partials.footer')

    <script>
        function toggleMenu() {
            document.getElementById('navDrawer').classList.toggle('active');
            document.getElementById('mobileOverlay').classList.toggle('active');
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to end your session?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#015551',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        const body = document.body;
        const toggleDesktop = document.getElementById('checkbox');
        const toggleMobile = document.getElementById('checkbox-mobile');

        if (localStorage.getItem('theme') === 'dark') {
            body.setAttribute('data-theme', 'dark');
            if (toggleDesktop) toggleDesktop.checked = true;
            if (toggleMobile) toggleMobile.checked = true;
        }

        function toggleTheme(el) {
            if (toggleDesktop) toggleDesktop.checked = el.checked;
            if (toggleMobile) toggleMobile.checked = el.checked;

            if (el.checked) {
                body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            }
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: 'var(--bg-card)',
            color: 'var(--text-main)',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    </script>
</body>

</html>
