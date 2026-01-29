@extends('layouts.user_layout')

@section('title', 'About Us - LibraryPRO')
{{-- Favicon layout me hona chahiye, par yahan bhi theek hai --}}
<link rel="icon" href="{{ asset('images/library-logo.png') }}" type="image/png">

@section('content')

    <style>
        /* 🟢 Variables use kar rahe hain taake Global Theme ke sath sync ho */
        .about-wrapper {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            /* 🌑 Auto Dark/Light */
            padding-bottom: 80px;
            transition: background 0.3s;
        }

        /* Main Container */
        .about-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        /* Split Section */
        .about-split {
            display: flex;
            align-items: center;
            gap: 50px;
            margin-bottom: 80px;
        }

        /* Left Side: Text */
        .about-text {
            flex: 1;
        }

        .section-title {
            color: var(--primary);
            /* 🌑 Theme Color */
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background: var(--accent);
            /* 🌑 Accent Color */
            bottom: -5px;
            left: 0;
            border-radius: 2px;
        }

        .about-desc {
            font-size: 1.1rem;
            color: var(--text-muted);
            /* 🌑 Auto Text Color */
            line-height: 1.8;
            margin-bottom: 25px;
            text-align: justify;
        }

        /* Mission Highlight Box */
        .mission-highlight {
            background: rgba(1, 85, 81, 0.08);
            /* Transparent tint works on both modes */
            border-left: 5px solid var(--primary);
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
            /* Dark mode correction for text inside highlight */
            color: var(--text-main);
        }

        [data-theme="dark"] .mission-highlight {
            background: rgba(255, 255, 255, 0.05);
            /* Thoda lighter for dark mode */
        }

        .mission-highlight h4 {
            color: var(--primary);
            margin-top: 0;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Right Side: Image Card */
        .about-image {
            flex: 1;
            position: relative;
        }

        .img-card {
            background: var(--bg-card);
            /* 🌑 Card Background */
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
            /* 🌑 Border for definition */
            transform: rotate(3deg);
            transition: all 0.4s ease;
        }

        .img-card:hover {
            transform: rotate(0deg) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .img-card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }

        /* Features Grid */
        .features-section {
            text-align: center;
        }

        .feat-heading {
            color: var(--primary);
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .feat-sub {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: var(--bg-card);
            /* 🌑 Card Background */
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            /* 🌑 Border */
            transition: translateY 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-bottom: 3px solid var(--accent);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .feature-card h3 {
            color: var(--primary);
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .about-split {
                flex-direction: column-reverse;
                text-align: center;
            }

            .about-text {
                text-align: left;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .section-title::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .img-card {
                transform: rotate(0deg);
                width: 100%;
                margin-bottom: 30px;
            }

            .img-card img {
                height: 300px;
            }
        }

        @media (max-width: 600px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="about-wrapper">
        <div class="about-container">

            <div class="about-split">
                <div class="about-text">
                    <h1 class="section-title">Who We Are</h1>
                    <p class="about-desc">
                        <strong>LibraryPRO</strong> is more than just a library management system; it is a digital sanctuary
                        for book lovers, researchers, and students. In a world overflowing with information, we provide a
                        structured, seamless, and intuitive way to access knowledge.
                    </p>
                    <p class="about-desc">
                        Founded with a vision to modernize traditional libraries, we combine cutting-edge technology with
                        the timeless joy of reading. Whether you are looking for academic resources or your next fictional
                        adventure, LibraryPRO is your trusted companion.
                    </p>

                    <div class="mission-highlight">
                        <h4><span>🎯</span> Our Mission</h4>
                        <p style="margin:0; font-size: 0.95rem;">
                            To make knowledge universally accessible by bridging the gap between physical books and digital
                            convenience, ensuring every reader finds their perfect book instantly.
                        </p>
                    </div>
                </div>

                <div class="about-image">
                    <div class="img-card">
                        {{-- Image path check kar lena --}}
                        <img src="{{ asset('images/libraryinterior.png') }}" alt="Library Interior">
                    </div>
                </div>
            </div>

            <div class="features-section">
                <h2 class="feat-heading">Why Choose LibraryPRO?</h2>
                <p class="feat-sub">Experience a library system built for the future.</p>

                <div class="features-grid">
                    <div class="feature-card">
                        <span class="feature-icon">📚</span>
                        <h3>Massive Collection</h3>
                        <p>Over 10,000+ books covering Science, Arts, Fiction, and History available at your fingertips.</p>
                    </div>

                    <div class="feature-card">
                        <span class="feature-icon">⚡</span>
                        <h3>Instant Access</h3>
                        <p>Reserve books online, check availability in real-time, and skip the waiting lines completely.</p>
                    </div>

                    <div class="feature-card">
                        <span class="feature-icon">🛡️</span>
                        <h3>Secure & Reliable</h3>
                        <p>Your reading history and personal data are kept private with our top-tier security protocols.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Note: Layout me footer already hai, isliye yahan se hata diya taake double footer na aaye --}}

@endsection
