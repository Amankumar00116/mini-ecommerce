<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password - MyShop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            background: #f4f6f8;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #2d3748;
        }

        .forgot-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .forgot-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 40px 36px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* Top Icon Badge */
        .icon-badge {
            width: 56px;
            height: 56px;
            background-color: #e6f4f1;
            color: #00796b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        .icon-badge svg {
            width: 26px;
            height: 26px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .title {
            font-size: 26px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #718096;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #2d3748;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }

        .form-input:focus {
            border-color: #00796b;
            box-shadow: 0 0 0 3px rgba(0, 121, 107, 0.15);
        }

        .reset-button {
            width: 100%;
            background: #00796b;
            color: #ffffff;
            border: none;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
            margin-top: 10px;
        }

        .reset-button:hover {
            background: #005b50;
        }

        .reset-button:active {
            transform: scale(0.99);
        }

        .back-login {
            display: inline-block;
            margin-top: 24px;
            color: #00796b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .back-login:hover {
            color: #005b50;
            text-decoration: underline;
        }

        .error-message {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 6px;
        }
    </style>
</head>

<body>

<div class="forgot-wrapper">

    <div class="forgot-card">

        <!-- ICON (Matches Login Page) -->
        <div class="icon-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>

        <div class="title">
            Forgot Password?
        </div>

        <div class="subtitle">
            Enter your email address below and we'll send you a link to reset your password.
        </div>

        <!-- SESSION STATUS -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- EMAIL -->
            <div class="form-group">
                <label for="email" class="form-label">
                    Email
                </label>

                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Enter your email"
                >

                @if($errors->get('email'))
                    <div class="error-message">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- BUTTON -->
            <button type="submit" class="reset-button">
                Send Reset Link
            </button>
        </form>

        <!-- BACK TO LOGIN -->
        <a href="{{ route('login') }}" class="back-login">
            ← Back to Login
        </a>

    </div>

</div>

</body>
</html>
