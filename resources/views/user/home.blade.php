<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryPRO - The Future of Knowledge</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="{{ asset('images/library-logo.png') }}" type="image/png">

    <style>
        :root {
            --bg-main: #f4f7f6;
            --bg-white: #ffffff;
            --primary: #015551;
            --primary-light: #00796b;
            --accent: #FE4F2D;
            --text-dark: #333333;
            --text-gray: #666666;
            --text-light: #ffffff;
            --glass-border: rgba(1, 85, 81, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
        }

        /* --- ANIMATIONS --- */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- HERO SECTION --- */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 80px 20px;
        }

        /* Background Image with Blur */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
            filter: blur(8px);
            transform: scale(1.1);
            z-index: -2;
        }

        /* Overlay */
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(244, 247, 246, 0.85);
            z-index: -1;
        }

        .hero-container {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 900px;
            width: 100%;
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 24px;
            border-radius: 50px;
            background: rgba(1, 85, 81, 0.1);
            border: 1px solid var(--primary-light);
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
            box-shadow: 0 0 20px rgba(1, 85, 81, 0.15);
            animation: pulse 2s infinite;
        }

        .hero-title {
            font-size: 4.5rem;
            line-height: 1.1;
            font-weight: 700;
            margin-bottom: 25px;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.25rem;
            color: var(--text-dark);
            font-weight: 500;
            max-width: 700px;
            margin: 0 auto 40px auto;
            line-height: 1.8;
        }

        /* --- BUTTONS --- */
        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            z-index: 5;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: 2px solid var(--primary);
            box-shadow: 0 10px 20px rgba(1, 85, 81, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(1, 85, 81, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(1, 85, 81, 0.2);
        }

        /* --- FLOATING ELEMENTS --- */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            /* Crucial: Allows clicking buttons underneath */
            z-index: 1;
            overflow: hidden;
        }

        .float-item {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(1, 85, 81, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            box-shadow: 0 10px 30px rgba(1, 85, 81, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .f1 {
            top: 15%;
            left: 5%;
            width: 70px;
            height: 70px;
            font-size: 30px;
            animation-delay: 0s;
        }

        .f2 {
            bottom: 15%;
            right: 8%;
            width: 90px;
            height: 90px;
            font-size: 35px;
            animation-delay: 2s;
        }

        .f3 {
            top: 18%;
            right: 12%;
            width: 50px;
            height: 50px;
            font-size: 20px;
            animation-delay: 4s;
        }

        /* --- STATS SECTION --- */
        .stats-section {
            padding: 80px 0;
            background: var(--primary);
            color: var(--text-light);
            position: relative;
            z-index: 2;
        }

        .stats-grid {
            display: flex;
            justify-content: center;
            gap: 60px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3.5rem;
            color: white;
            margin: 0;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .stat-item p {
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            margin-top: 5px;
        }

        /* --- FEATURES --- */
        .features {
            padding: 100px 20px;
            background: var(--bg-main);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .section-header p {
            color: var(--text-gray);
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .feature-card {
            background: var(--bg-white);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: 0.4s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(1, 85, 81, 0.1);
            border-color: var(--primary-light);
        }

        .f-icon {
            width: 60px;
            height: 60px;
            background: rgba(1, 85, 81, 0.1);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* --- TESTIMONIALS --- */
        .testimonials {
            padding: 100px 20px;
            background: #eaeff2;
        }

        .t-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .t-card {
            background: var(--bg-white);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        .t-user {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .t-avatar {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }

        .quote {
            font-style: italic;
            color: var(--text-gray);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* --- ANIMATION KEYFRAMES --- */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(1, 85, 81, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(1, 85, 81, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(1, 85, 81, 0);
            }
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }

            .hero {
                padding-top: 120px;
            }

            /* Space for fixed header */
            .stats-grid {
                gap: 40px;
            }

            .f1,
            .f2,
            .f3 {
                display: none;
            }

            /* Hide floaters on mobile to save space */
        }
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">

        <div class="floating-elements">
            <div class="float-item f1"><i class="fas fa-book"></i></div>
            <div class="float-item f2"><i class="fas fa-graduation-cap"></i></div>
            <div class="float-item f3"><i class="fas fa-lightbulb"></i></div>
        </div>

        <div class="hero-container">

            @auth
                @if (auth()->user()->role === 'admin')
                    <div class="reveal active"> <span class="hero-badge">Administrator Access</span>
                        <h1 class="hero-title">Command Your<br>Library Empire</h1>
                        <p class="hero-desc">
                            Manage inventory, approve user requests, and analyze borrowing trends with our state-of-the-art
                            admin dashboard.
                        </p>
                        <div class="btn-group">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            <a href="{{ route('books.create') }}" class="btn btn-outline">Add New Book</a>
                        </div>
                    </div>
                @else
                    <div class="reveal active">
                        <span class="hero-badge">Premium Digital Library</span>
                        <h1 class="hero-title">Unlock Infinite<br>Knowledge</h1>
                        <p class="hero-desc">
                            Welcome back, <strong>{{ auth()->user()->name }}</strong>. Dive into our curated collection of
                            books and discover your next obsession.
                        </p>
                        <div class="btn-group">
                            <a href="{{ route('books.category', 'all') }}" class="btn btn-primary">Browse Library</a>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline">My Dashboard</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="reveal active">
                    <span class="hero-badge">Next-Gen Library System</span>
                    <h1 class="hero-title">The Future of<br>Reading is Here</h1>
                    <p class="hero-desc">
                        Experience a seamless, powerful, and elegant way to manage books. LibraryPRO bridges the gap between
                        traditional libraries and modern technology.
                    </p>
                    <div class="btn-group">
                        <a href="{{ route('login') }}" class="btn btn-primary">Start Reading</a>
                        <a href="{{ route('about') }}" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
            @endauth

        </div>
    </section>

    <section class="stats-section reveal" id="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <h3 class="counter" data-target="5000">0</h3>
                <p>Books Available</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="1200">0</h3>
                <p>Active Students</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="850">0</h3>
                <p>Happy Readers</p>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-header reveal">
            <h2>Why LibraryPRO?</h2>
            <p>Built for speed, security, and simplicity.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="f-icon"><i class="fas fa-search"></i></div>
                <h3>Instant Search</h3>
                <p>Find any book in milliseconds. Sort by author, category, or title.</p>
            </div>
            <div class="feature-card reveal">
                <div class="f-icon"><i class="fas fa-mobile-screen"></i></div>
                <h3>Fully Responsive</h3>
                <p>Access the library from your phone, tablet, or desktop flawlessly.</p>
            </div>
            <div class="feature-card reveal">
                <div class="f-icon"><i class="fas fa-lock"></i></div>
                <h3>Secure System</h3>
                <p>Enterprise-grade security ensures user data is always protected.</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="section-header reveal">
            <h2>What People Say</h2>
            <p>Trusted by students and faculty members.</p>
        </div>

        <div class="t-grid">
            <div class="t-card reveal">
                <div class="t-user">
                    <div class="t-avatar">A</div>
                    <div><strong>Ali Khan</strong><br><small style="color:#64748b">Computer Science</small></div>
                </div>
                <p class="quote">"This is hands down the best library system I've used. The interface is clean and
                    super fast."</p>
            </div>

            <div class="t-card reveal">
                <div class="t-user">
                    <div class="t-avatar">S</div>
                    <div><strong>Sara Ahmed</strong><br><small style="color:#64748b">Literature</small></div>
                </div>
                <p class="quote">"I love how easy it is to track my due dates. The dashboard is a life saver."</p>
            </div>

            <div class="t-card reveal">
                <div class="t-user">
                    <div class="t-avatar">U</div>
                    <div><strong>Usman Riaz</strong><br><small style="color:#64748b">Business</small></div>
                </div>
                <p class="quote">"Requesting books used to be a pain. With LibraryPRO, it takes just one click."</p>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
        // 1. SCROLL REVEAL ANIMATION
        window.addEventListener('scroll', reveal);

        function reveal() {
            var reveals = document.querySelectorAll('.reveal');
            var windowheight = window.innerHeight;
            var revealpoint = 150;

            for (var i = 0; i < reveals.length; i++) {
                var revealtop = reveals[i].getBoundingClientRect().top;
                if (revealtop < windowheight - revealpoint) {
                    reveals[i].classList.add('active');
                }
            }
        }
        reveal(); // Trigger once on load

        // 2. COUNTER ANIMATION (With Intersection Observer for better performance)
        const statsSection = document.getElementById('stats-section');
        const counters = document.querySelectorAll('.counter');
        let hasCounted = false;

        const runCounters = () => {
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const speed = 100; // Lower is slower
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 25);
                    } else {
                        counter.innerText = target + "+";
                    }
                }
                updateCount();
            });
        };

        // Use Intersection Observer to run counter ONLY when visible
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !hasCounted) {
                runCounters();
                hasCounted = true; // Run only once
            }
        }, {
            threshold: 0.5
        }); // Trigger when 50% visible

        observer.observe(statsSection);
    </script>

</body>

</html>
