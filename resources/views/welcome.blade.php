<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryPRO - Modern Library Management</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="icon" href="{{ asset('images/library-logo.png') }}" type="image/png">

    <style>
        :root {
            --primary: #015551;
            --accent: #FE4F2D;
            --dark: #0b1a19;
            --light: #f4f7f6;
            --glass: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark);
            color: white;
            overflow-x: hidden;
        }

        /* --- ANIMATIONS --- */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes glow {
            0% { box-shadow: 0 0 5px rgba(1, 85, 81, 0.2); }
            50% { box-shadow: 0 0 20px rgba(1, 85, 81, 0.6), 0 0 10px var(--accent); }
            100% { box-shadow: 0 0 5px rgba(1, 85, 81, 0.2); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* --- HERO SECTION --- */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(1, 85, 81, 0.9), rgba(11, 26, 25, 0.95)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
        }

        .hero-content {
            text-align: center;
            max-width: 1000px;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(235, 225, 225, 0.315);
            backdrop-filter: blur(5px);
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid rgba(138, 124, 124, 0.2);
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: 60px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(to right, #ffffff, #b2dfdb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideInUp 0.8s ease-out;
        }

        .hero-desc {
            font-size: 18px;
            color: #d1d5db;
            margin-bottom: 40px;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            animation: slideInUp 1s ease-out;
        }

        /* --- ACTION GRID (Buttons) --- */
        .action-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            animation: slideInUp 1.2s ease-out;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-glass::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-glass:hover::before {
            left: 100%;
        }

        .btn-glass:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
        }
        .btn-primary:hover {
            background: #d63c1f;
        }

        /* --- FLOATING 3D ELEMENT (Visual) --- */
        .floating-book {
            font-size: 100px;
            color: rgba(255,255,255,0.1);
            position: absolute;
            top: 20%;
            right: 10%;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }
        .floating-circle {
            width: 300px; height: 300px;
            background: var(--primary);
            filter: blur(100px);
            border-radius: 50%;
            position: absolute;
            bottom: -50px; left: -50px;
            opacity: 0.5;
            z-index: 1;
        }

        /* --- FEATURES SECTION --- */
        .features-section {
            padding: 80px 20px;
            background: white;
            color: #333;
            text-align: center;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 50px;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            width: 60px; height: 4px;
            background: var(--accent);
            position: absolute;
            bottom: -10px; left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(1, 85, 81, 0.15);
            border-color: var(--primary);
        }

        .f-icon {
            width: 70px; height: 70px;
            background: #e0f2f1;
            color: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px auto;
            transition: 0.3s;
        }

        .feature-card:hover .f-icon {
            background: var(--primary);
            color: white;
            transform: rotateY(180deg);
        }

        .feature-card h3 { margin-bottom: 10px; font-weight: 700; }
        .feature-card p { color: #666; font-size: 15px; line-height: 1.6; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 40px; }
            .action-grid { flex-direction: column; }
            .btn-glass { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

@include('layouts.admin_layout')

<div class="hero-section">
    
    <i class="fas fa-book-open floating-book"></i>
    <div class="floating-circle"></div>

    <div class="hero-content">
        
        @auth
            @if (auth()->user()->role === 'admin')
                <span class="hero-badge">⚡ Admin Access Granted</span>
                <h1 class="hero-title">Command Center</h1>
                <p class="hero-desc">
                    Welcome back, <strong>{{ auth()->user()->name }}</strong>. You have full control over the library ecosystem. Manage books, approve users, and track requests in real-time.
                </p>
                
                <div class="action-grid">
                    <a href="{{ route('admin.dashboard') }}" class="btn-glass btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('books.create') }}" class="btn-glass">
                        <i class="fas fa-plus-circle"></i> Add Book
                    </a>
                    {{-- <a href="{{ route('admin.requests') }}" class="btn-glass">
                        <i class="fas fa-bell"></i> Requests
                    </a>
                    <a href="{{ route('admin.messages') }}" class="btn-glass">
                        <i class="fas fa-envelope"></i> Inbox
                    </a> --}}
                </div>

            @else
                <span class="hero-badge">📚 Premium Library Experience</span>
                <h1 class="hero-title">Discover Your Next<br>Great Read</h1>
                <p class="hero-desc">
                    Explore thousands of titles, manage your reading list, and get instant access to knowledge. Your personal digital library awaits.
                </p>

                <div class="action-grid">
                    <a href="{{ route('books.category', 'all') }}" class="btn-glass btn-primary">
                        <i class="fas fa-search"></i> Browse Library
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn-glass">
                        <i class="fas fa-user-circle"></i> My Dashboard
                    </a>
                    <a href="{{ route('contact') }}" class="btn-glass">
                        <i class="fas fa-headset"></i> Support
                    </a>
                </div>
            @endif

        @else
            <span class="hero-badge">🎓 The Future of Learning</span>
            <h1 class="hero-title">Welcome to<br>LibraryPRO</h1>
            <p class="hero-desc">
                A smart, seamless, and powerful library management system designed for modern institutions. Join us today to start your journey.
            </p>

            <div class="action-grid">
                <a href="{{ route('login') }}" class="btn-glass btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login Now
                </a>
                <a href="{{ route('register') }}" class="btn-glass">
                    <i class="fas fa-user-plus"></i> Join for Free
                </a>
                <a href="{{ route('about') }}" class="btn-glass">
                    <i class="fas fa-info-circle"></i> Learn More
                </a>
            </div>
        @endauth

    </div>
</div>

<section class="features-section">
    <div class="container">
        <h2 class="section-title">Why Choose LibraryPRO?</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="f-icon"><i class="fas fa-bolt"></i></div>
                <h3>Lightning Fast</h3>
                <p>Experience instant search and seamless navigation with our optimized CRUD engine.</p>
            </div>

            <div class="feature-card">
                <div class="f-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Secure & Safe</h3>
                <p>Your data is protected with enterprise-grade security and role-based access control.</p>
            </div>

            <div class="feature-card">
                <div class="f-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Fully Responsive</h3>
                <p>Access the library from any device - Desktop, Tablet, or Mobile. It looks great everywhere.</p>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')

</body>
</html>