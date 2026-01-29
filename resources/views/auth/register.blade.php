<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- THEME COLORS --- */
        :root {
            var(--primary-green: #015551); 
            var(--secondary-green: #02736d); 
            var(--bg-light: #e0f2f1);
            var(--text-dark: #003330);
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0; padding: 0; height: 100vh;
            overflow: hidden;
            display: flex; justify-content: center; align-items: center;
            background: linear-gradient(135deg, #e0f2f1 0%, #ffffff 100%);
            position: relative;
        }

        /* --- BACKGROUND ANIMATED BOOKS --- */
        .abstract-book-container {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            overflow: hidden; z-index: 1;
        }

        .abstract-book {
            position: absolute; display: block; width: 80px; height: 110px;
            background: rgba(1, 85, 81, 0.05);
            border: 1px solid rgba(1, 85, 81, 0.1);
            backdrop-filter: blur(2px); border-radius: 4px;
            bottom: -150px; animation: floatUp 25s infinite linear;
        }

        .b1 { left: 10%; width: 100px; height: 140px; animation-duration: 25s; }
        .b2 { left: 20%; width: 60px; height: 80px; animation-delay: 2s; animation-duration: 18s; background: rgba(1, 85, 81, 0.08); }
        .b3 { left: 35%; width: 120px; height: 160px; animation-delay: 4s; animation-duration: 28s; }
        .b4 { left: 50%; width: 80px; height: 110px; animation-delay: 0s; animation-duration: 22s; background: rgba(1, 85, 81, 0.07); }
        .b5 { left: 65%; width: 110px; height: 150px; animation-delay: 6s; animation-duration: 30s; }
        .b6 { left: 80%; width: 70px; height: 90px; animation-delay: 3s; animation-duration: 20s; background: rgba(1, 85, 81, 0.06); }
        .b7 { left: 90%; width: 90px; height: 120px; animation-delay: 7s; animation-duration: 24s; }

        @keyframes floatUp {
            0% { transform: translateY(0) rotate(0deg) scale(0.8); opacity: 0; }
            20% { opacity: 0.7; } 80% { opacity: 0.7; }
            100% { transform: translateY(-110vh) rotate(720deg) scale(1.1); opacity: 0; }
        }

        /* --- THE GLASS CARD --- */
        .main-card {
            width: 1000px; height: 600px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(1, 85, 81, 0.1);
            overflow: hidden; display: flex; position: relative; z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        /* --- LEFT SIDE (Visuals) --- */
        .card-visuals {
            flex: 1; background: #fff;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            padding: 40px; position: relative; overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 88% 100%, 0% 100%);
        }

        .circle { position: absolute; border-radius: 50%; opacity: 0.1; }
        .c1 { width: 250px; height: 250px; background: linear-gradient(135deg, #015551, #02736d); top: -60px; left: -60px; }
        .c2 { width: 350px; height: 350px; background: linear-gradient(135deg, #02736d, #015551); bottom: -120px; right: -80px; }

        .illustration-box { text-align: center; z-index: 2; }

        .floating-icon {
            font-size: 110px;
            background: linear-gradient(45deg, #015551, #02736d);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 10px 15px rgba(1, 85, 81, 0.2));
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }

        .visual-text { margin-top: 25px; }
        .visual-text h2 { font-weight: 700; color: #003330; margin-bottom: 10px; }
        .visual-text p { color: #666; font-size: 15px; max-width: 320px; margin: 0 auto; line-height: 1.6; }

        /* --- RIGHT SIDE (Form) --- */
        .card-form { flex: 1; padding: 40px 60px; display: flex; flex-direction: column; justify-content: center; background: rgba(255,255,255,0.4); }

        .welcome-header { margin-bottom: 25px; }
        .welcome-header h3 { font-weight: 700; color: #003330; font-size: 26px; margin-bottom: 8px; }
        .welcome-header p { color: #777; font-size: 14px; }

        /* Input Styling */
        .input-group-modern { position: relative; margin-bottom: 20px; }
        .input-group-modern i {
            position: absolute; left: 18px; top: 50%; transform: translateY(-50%);
            color: #aaa; transition: all 0.4s ease; font-size: 18px;
        }
        .input-group-modern input {
            width: 100%; padding: 16px 16px 16px 55px;
            border: 2px solid #eef2f1; border-radius: 12px;
            background: #f8fdfb; font-size: 15px; color: #003330;
            transition: all 0.4s ease; outline: none; font-weight: 500;
        }
        .input-group-modern input:hover { border-color: #d0e2e0; }
        .input-group-modern input:focus {
            background: #fff; border-color: #015551;
            box-shadow: 0 8px 20px rgba(1, 85, 81, 0.1);
        }
        .input-group-modern input:focus + i { color: #015551; }
        .toggle-pass { left: auto !important; right: 18px; cursor: pointer; }

        /* Button */
        .btn-modern {
            width: 100%; padding: 16px; border: none; border-radius: 12px;
            background: linear-gradient(to right, #015551, #02736d);
            background-size: 200% auto;
            color: white; font-weight: 600; font-size: 16px; letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(1, 85, 81, 0.25);
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .btn-modern:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(1, 85, 81, 0.35);
        }

        .register-text { text-align: center; margin-top: 20px; color: #666; font-size: 14px; }
        .register-text a { color: #015551; text-decoration: none; font-weight: 700; transition: color 0.3s; }
        .register-text a:hover { text-decoration: underline; }

        /* Alerts */
        .alert-style { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alert-err { background: #fff1f0; color: #c0392b; border-left: 5px solid #c0392b; }

        @media(max-width: 900px) {
            .main-card { width: 92%; height: auto; flex-direction: column; }
            .card-visuals { display: none; }
            .card-form { padding: 40px 25px; }
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
        <div class="abstract-book b7"></div>
    </div>

    <div class="main-card">
        
        <div class="card-visuals">
            <div class="circle c1"></div>
            <div class="circle c2"></div>
            
            <div class="illustration-box">
                <i class="fas fa-graduation-cap floating-icon"></i>
                <div class="visual-text">
                    <h2>Join the Community.</h2>
                    <p>Create your library card today and start your journey.</p>
                </div>
            </div>
        </div>

        <div class="card-form">
            <div class="welcome-header">
                <h3>Create Account</h3>
                <p>Fill in your details to get started.</p>
            </div>

            @if ($errors->any())
                <div class="alert-style alert-err">
                    <div>
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                
                <div class="input-group-modern">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Full Name" required autocomplete="off">
                </div>

                <div class="input-group-modern">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required autocomplete="off">
                </div>

                <div class="input-group-modern">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="regPassword" placeholder="Create Password" required>
                    <i class="fas fa-eye toggle-pass" onclick="togglePassword('regPassword', this)"></i>
                </div>

                <button type="submit" class="btn-modern">
                    Sign Up Now
                </button>
            </form>

            <div class="register-text">
                Already a member? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>