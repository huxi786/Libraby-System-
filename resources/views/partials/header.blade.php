<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    :root {
        --primary: #015551;
        --primary-dark: #013f3e;
        --accent: #FE4F2D;
        --light-bg: #f4f7f6;
        --text-dark: #333;
        --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* --- HEADER CONTAINER --- */
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        background: rgba(255, 255, 255, 0.95);
        /* Glass Effect */
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Poppins', sans-serif;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    /* --- LOGO --- */
    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 800;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
    }

    .logo img {
        height: 40px;
        width: auto;
        filter: drop-shadow(0 4px 6px rgba(1, 85, 81, 0.2));
    }

    /* --- NAVIGATION --- */
    .nav-links {
        display: flex;
        gap: 8px;
        background: rgba(1, 85, 81, 0.04);
        padding: 5px;
        border-radius: 50px;
    }

    .nav-links a {
        padding: 10px 20px;
        color: #555;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border-radius: 30px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .nav-links a:hover {
        color: var(--primary);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .nav-links a.active {
        background: var(--primary);
        color: white !important;
        box-shadow: 0 4px 15px rgba(1, 85, 81, 0.3);
        transform: translateY(-1px);
    }

    /* --- AUTH BUTTONS & USER PROFILE --- */
    .auth-buttons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Login Button */
    .login-btn {
        padding: 10px 30px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(1, 85, 81, 0.2);
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: var(--accent);
        box-shadow: 0 6px 20px rgba(254, 79, 45, 0.3);
        transform: translateY(-2px);
    }

    /* User Profile Capsule (Jab Login ho) */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fa;
        padding: 6px 6px 6px 20px;
        /* Left padding text ke liye */
        border-radius: 50px;
        border: 1px solid #eee;
        transition: 0.3s;
    }

    .user-info:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border-color: #e0e0e0;
    }

    .welcome-msg {
        font-size: 13px;
        color: #666;
        font-weight: 500;
        line-height: 1.2;
    }

    .user-name {
        display: block;
        color: var(--primary);
        font-weight: 700;
        font-size: 14px;
    }

    /* Logout Button (Icon Style) */
    .logout-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffe5e5;
        color: #dc3545;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .logout-btn i {
        font-size: 14px;
    }

    .logout-btn:hover {
        background: #dc3545;
        color: white;
        transform: rotate(90deg);
        /* Cool rotation effect */
    }

    /* --- DASHBOARD BUTTON (For future use) --- */
    .dash-btn {
        padding: 8px 15px;
        font-size: 13px;
        border-radius: 8px;
        background: #fff3e0;
        color: #f57c00;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
        border: 1px solid #ffe0b2;
    }

    .dash-btn:hover {
        background: #ffe0b2;
        transform: translateY(-2px);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
        .main-header {
            padding: 15px 20px;
        }

        .nav-links a {
            padding: 8px 15px;
            font-size: 13px;
        }
    }

    @media (max-width: 768px) {
        .main-header {
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .logo {
            width: 100%;
            justify-content: center;
            margin-bottom: 5px;
        }

        .nav-links {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }

        .auth-buttons {
            margin-top: 10px;
        }

        .welcome-msg {
            display: none;
        }

        /* Mobile pe sirf logout dikhao space bachane ke liye */
        .user-info {
            padding: 5px;
            border: none;
            background: transparent;
        }

        .logout-btn {
            width: 40px;
            height: 40px;
        }
    }
</style>

<header class="main-header">

    <a href="{{ route('admin.welcome') }}" class="logo">
        @if (file_exists(public_path('images/library-logo.png')))
            <img src="{{ asset('images/library-logo.png') }}" alt="Library Logo">
        @else
            <i class="fas fa-book-reader" style="font-size: 32px;"></i>
        @endif
        <span>LibraryPRO</span>
    </a>

    <nav class="nav-links">
        <a href="{{ route('admin.welcome') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="{{ route('books.category', 'all') }}"
            class="{{ request()->routeIs('books.category') || request()->routeIs('books.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Books
        </a>
        <a href="#">
            <i class="fas fa-feather-alt"></i> Authors
        </a>
        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                <i class="fas fa-comment-alt"></i> Messages
            </a>
        @endif
    </nav>

    <div class="auth-buttons">

        {{-- Dashboard Button (Hidden logic kept as requested) --}}
        @auth
            {{-- @if (Auth::user()->role === 'admin')
               <a href="{{ route('admin.dashboard') }}" class="dash-btn">Dashboard</a>
            @endif --}}
        @endauth

        @auth
            <div class="user-info">
                <div class="welcome-msg">
                    Welcome back,<br>
                    <span class="user-name">{{ explode(' ', Auth::user()->name)[0] }}</span>
                </div>

                <a href="{{ route('logout') }}" class="logout-btn" title="Logout">
                    <i class="fas fa-power-off"></i>
                </a>
            </div>
        @else
            <a href="{{ route('login') }}">
                <button class="login-btn">Login <i class="fas fa-arrow-right"
                        style="margin-left:5px; font-size:12px;"></i></button>
            </a>
        @endauth

    </div>

</header>
