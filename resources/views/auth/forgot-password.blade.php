
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LibraryPRO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #015551;
            --primary-dark: #013f3e;
            --accent: #FE4F2D;
            --bg-color: #f0f4f3;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background decoration */
            background-image: radial-gradient(circle at 10% 20%, rgba(1, 85, 81, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(254, 79, 45, 0.05) 0%, transparent 20%);
        }

        /* --- THE CARD --- */
        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            /* Glass Effect */
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-align: center;
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        /* Top Color Bar */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        /* --- ICON ANIMATION --- */
        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(1, 85, 81, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 20px auto;
            animation: float 3s ease-in-out infinite;
        }

        h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 24px;
        }

        p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* --- FLOATING INPUT --- */
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-field {
            width: 100%;
            padding: 15px 15px 15px 45px;
            /* Space for icon */
            border: 2px solid #eee;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .input-field:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 5px 15px rgba(1, 85, 81, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: 0.3s;
        }

        .input-field:focus+.input-icon {
            color: var(--primary);
        }

        /* --- BUTTON --- */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(1, 85, 81, 0.2);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(1, 85, 81, 0.3);
        }

        /* --- ALERTS --- */
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #badbcc;
        }

        .error-msg {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        /* --- BACK LINK --- */
        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link i {
            margin-right: 5px;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .back-link:hover i {
            transform: translateX(-5px);
        }

        /* --- ANIMATIONS --- */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 500px) {
            .auth-card {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="icon-circle">
            <i class="fas fa-lock"></i>
        </div>

        <h2>Forgot Password?</h2>
        <p>No worries! Enter the email address associated with your account, and we'll send you a link to reset it.</p>

        @if (session('status'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="input-group">
                <input type="email" name="email" class="input-field" placeholder="Enter your email" required>
                <i class="fas fa-envelope input-icon"></i> @error('email')
                    <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Send Reset Link <i class="fas fa-paper-plane"></i>
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>

</body>

</html>
