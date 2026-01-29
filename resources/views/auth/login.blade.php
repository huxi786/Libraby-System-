<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- THEME COLORS --- */
        :root {
            --primary-green: #015551;
            --secondary-green: #02736d;
            --bg-light: #e0f2f1;
            --text-dark: #003330;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--bg-light) 0%, #ffffff 100%);
            position: relative;
        }

        /* --- BACKGROUND ANIMATION --- */
        .abstract-book-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .abstract-book {
            position: absolute;
            display: block;
            width: 80px;
            height: 110px;
            background: rgba(1, 85, 81, 0.05);
            border: 1px solid rgba(1, 85, 81, 0.1);
            backdrop-filter: blur(2px);
            border-radius: 4px;
            bottom: -150px;
            animation: floatUp 25s infinite linear;
        }

        .b1 {
            left: 10%;
            width: 100px;
            height: 140px;
            animation-duration: 25s;
        }

        .b2 {
            left: 20%;
            width: 60px;
            height: 80px;
            animation-delay: 2s;
            animation-duration: 18s;
            background: rgba(1, 85, 81, 0.08);
        }

        .b3 {
            left: 35%;
            width: 120px;
            height: 160px;
            animation-delay: 4s;
            animation-duration: 28s;
        }

        .b4 {
            left: 50%;
            width: 80px;
            height: 110px;
            animation-delay: 0s;
            animation-duration: 22s;
            background: rgba(1, 85, 81, 0.07);
        }

        .b5 {
            left: 65%;
            width: 110px;
            height: 150px;
            animation-delay: 6s;
            animation-duration: 30s;
        }

        .b6 {
            left: 80%;
            width: 70px;
            height: 90px;
            animation-delay: 3s;
            animation-duration: 20s;
            background: rgba(1, 85, 81, 0.06);
        }

        .b7 {
            left: 90%;
            width: 90px;
            height: 120px;
            animation-delay: 7s;
            animation-duration: 24s;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(0.8);
                opacity: 0;
            }

            100% {
                transform: translateY(-110vh) rotate(720deg) scale(1.1);
                opacity: 0;
            }
        }

        /* --- CARD STYLES --- */
        .main-card {
            width: 1000px;
            height: 600px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(1, 85, 81, 0.1);
            overflow: hidden;
            display: flex;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .card-visuals {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 88% 100%, 0% 100%);
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .c1 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            top: -60px;
            left: -60px;
        }

        .c2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            bottom: -120px;
            right: -80px;
        }

        .illustration-box {
            text-align: center;
            z-index: 2;
        }

        .floating-icon {
            font-size: 110px;
            background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 10px 15px rgba(1, 85, 81, 0.2));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .visual-text {
            margin-top: 25px;
        }

        .visual-text h2 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .visual-text p {
            color: #666;
            font-size: 15px;
            max-width: 320px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* --- FORM SIDE --- */
        .card-form {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.4);
            overflow-y: auto;
            /* Small screens safety */
        }

        .welcome-header {
            margin-bottom: 20px;
        }

        .welcome-header h3 {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 26px;
            margin-bottom: 5px;
        }

        .welcome-header p {
            color: #777;
            font-size: 14px;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group-modern i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: all 0.4s ease;
            font-size: 18px;
        }

        .input-group-modern input {
            width: 100%;
            padding: 14px 16px 14px 55px;
            border: 2px solid #eef2f1;
            border-radius: 12px;
            background: #f8fdfb;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.4s ease;
            outline: none;
            font-weight: 500;
        }

        .input-group-modern input:focus {
            background: #fff;
            border-color: var(--primary-green);
            box-shadow: 0 8px 20px rgba(1, 85, 81, 0.1);
        }

        .input-group-modern input:focus+i {
            color: var(--primary-green);
        }

        .toggle-pass {
            left: auto !important;
            right: 18px;
            cursor: pointer;
        }

        .btn-modern {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--primary-green), var(--secondary-green));
            background-size: 200% auto;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(1, 85, 81, 0.25);
            transition: all 0.5s ease;
        }

        .btn-modern:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(1, 85, 81, 0.35);
        }

        /* Google Button & Divider */
        .divider {
            text-align: center;
            position: relative;
            margin: 15px 0;
        }

        .divider span {
            background: #fcfcfc;
            padding: 0 10px;
            color: #999;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }

        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: #ddd;
            z-index: 0;
        }

        .btn-google {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: white;
            color: #555;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            border-color: #ccc;
        }

        .btn-google img {
            width: 18px;
        }

        .register-text {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 13px;
        }

        .register-text a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 700;
        }

        /* 🟢 NEW: Contact Support Section */
        .contact-support {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
            text-align: center;
        }

        .cs-title {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cs-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cs-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            background: rgba(1, 85, 81, 0.05);
            padding: 5px 12px;
            border-radius: 20px;
        }

        .cs-item:hover {
            background: var(--primary-green);
            color: white;
            transform: scale(1.05);
        }

        .cs-item i {
            color: var(--primary-green);
        }

        .cs-item:hover i {
            color: white;
        }

        .alert-style {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-err {
            background: #fff1f0;
            color: #c0392b;
            border-left: 4px solid #c0392b;
        }

        .alert-suc {
            background: #edffef;
            color: var(--primary-green);
            border-left: 4px solid var(--primary-green);
        }

        @media(max-width: 900px) {
            .main-card {
                width: 95%;
                height: auto;
                flex-direction: column;
            }

            .card-visuals {
                display: none;
            }

            .card-form {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="abstract-book-container">
        <div class="abstract-book b1"></div>
        <div class="abstract-book b2"></div>
        <div class="abstract-book b3"></div>
        <div class="abstract-book b4"></div>
        <div class="abstract-book b5"></div>
        <div class="abstract-book b6"></div>
    </div>

    <div class="main-card">
        {{-- Left Visuals --}}
        <div class="card-visuals">
            <div class="circle c1"></div>
            <div class="circle c2"></div>
            <div class="illustration-box">
                <i class="fas fa-book-reader floating-icon"></i>
                <div class="visual-text">
                    <h2>Welcome Scholar.</h2>
                    <p>Your gateway to endless knowledge.</p>
                </div>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="card-form">
            <div class="welcome-header">
                <h3>Sign In</h3>
                <p>Access your library account.</p>
            </div>

            @if (session('error'))
                <div class="alert-style alert-err"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert-style alert-suc"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="input-group-modern">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required autocomplete="off">
                </div>
                <div class="input-group-modern">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="loginPassword" placeholder="Password" required>
                    <i class="fas fa-eye toggle-pass" onclick="togglePassword('loginPassword', this)"></i>
                </div>
                <button type="submit" class="btn-modern">Login Now</button>
            </form>

            <div class="divider"><span>OR</span></div>

            <a href="{{ route('google.login') }}" class="btn-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                Sign in with Google
            </a>

            <div class="mt-2 text-end">
                <a href="{{ route('password.request') }}"
                    style="text-decoration: none; color: #015551; font-size: 13px;">Forgot Password?</a>
            </div>

            <div class="register-text">
                Not a member? <a href="{{ route('register') }}">Register here</a>
            </div>

            {{-- 🟢 NEW: CONTACT SUPPORT SECTION --}}
            <div class="contact-support">
                <div class="cs-title">Need Approval or Help?</div>
                <div class="cs-links">
                    {{-- Apna Number/Email Yahan Edit Karein --}}
                    <a href="tel:+923001234567" class="cs-item"><i class="fas fa-phone-alt"></i> +92 300 1234567</a>
                    <a href="mailto:admin@library.com" class="cs-item"><i class="fas fa-envelope"></i> Email Admin</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, icon) {
            const inp = document.getElementById(id);
            if (inp.type === "password") {
                inp.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                inp.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>

</html>
