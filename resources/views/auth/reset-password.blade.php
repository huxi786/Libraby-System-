<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LibraryPRO</title>
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
            background-image: radial-gradient(circle at 10% 20%, rgba(1, 85, 81, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(254, 79, 45, 0.05) 0%, transparent 20%);
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-align: center;
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
        }

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
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-label {
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
            display: block;
            margin-left: 5px;
        }

        .input-field {
            width: 100%;
            padding: 15px 45px 15px 45px;
            /* Right padding badhaya taake eye icon text ke upar na aaye */
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

        .input-field.readonly {
            background-color: #e9ecef;
            color: #6c757d;
            border-color: #dee2e6;
            cursor: not-allowed;
        }

        /* Left Icon */
        .input-icon {
            position: absolute;
            left: 15px;
            bottom: 17px;
            color: #999;
            transition: 0.3s;
        }

        .input-field:focus+.input-icon {
            color: var(--primary);
        }

        /* --- 👁️ EYE TOGGLE ICON (Right Side) --- */
        .toggle-password {
            position: absolute;
            right: 15px;
            bottom: 17px;
            color: #999;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

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
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(1, 85, 81, 0.2);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(1, 85, 81, 0.3);
        }

        .error-msg {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
            margin-left: 5px;
        }

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
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="icon-circle"><i class="fas fa-shield-halved"></i></div>

        <h2>Secure Your Account</h2>
        <p>Please create a strong password to protect your library account.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-group">
                <span class="input-label">Email Address</span>
                <input type="email" name="email" class="input-field readonly" value="{{ $email ?? old('email') }}"
                    required readonly>
                <i class="fas fa-envelope input-icon"></i>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <span class="input-label">New Password</span>
                <input type="password" name="password" id="new_password" class="input-field"
                    placeholder="At least 8 characters" required>
                <i class="fas fa-lock input-icon"></i>

                <i class="fas fa-eye toggle-password" onclick="togglePass('new_password', this)"></i>

                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <span class="input-label">Confirm Password</span>
                <input type="password" name="password_confirmation" id="confirm_password" class="input-field"
                    placeholder="Repeat password" required>
                <i class="fas fa-check-circle input-icon"></i>

                <i class="fas fa-eye toggle-password" onclick="togglePass('confirm_password', this)"></i>
            </div>

            <button type="submit" class="btn-submit">
                Reset Password <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
            </button>
        </form>
    </div>

    <script>
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash"); // Slash wala icon
            } else {
                input.type = "password";
                icon.classList.add("fa-eye");
                icon.classList.remove("fa-eye-slash"); // Wapis normal eye
            }
        }
    </script>

</body>

</html>
