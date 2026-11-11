<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password - MyShop</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .reset-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-card {
            width: 420px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #172337;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
        }

        .form-input:focus {
            border-color: #1677ff;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .reset-button {
            width: 100%;
            background: #1677ff;
            color: white;
            border: none;
            padding: 11px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
        }

        .reset-button:hover {
            background: #0d6efd;
        }
    </style>
</head>

<body>

<div class="reset-wrapper">

    <div class="reset-card">

        <div class="logo">
            MyShop
        </div>

        <div class="subtitle">
            Create a new password for your account
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden"
                   name="token"
                   value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group">

                <label for="email" class="form-label">
                    Email Address
                </label>

                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                >

                @if($errors->get('email'))
                    <div class="error">
                        {{ $errors->first('email') }}
                    </div>
                @endif

            </div>


            <!-- Password -->
            <div class="form-group">

    <label for="password" class="form-label">
        New Password
    </label>

    <div style="position:relative; width:100%;">

        <input
            id="password"
            class="form-input"
            type="password"
            name="password"
            required
            autocomplete="new-password"
            style="padding-right:45px;"
        >

        <i
            class="bi bi-eye"
            id="eyeIcon"
            onclick="togglePassword('password', 'eyeIcon')"
            style="
                position:absolute;
                right:12px;
                top:50%;
                transform:translateY(-50%);
                cursor:pointer;
                font-size:18px;
                color:#777;
            "
        ></i>

    </div>

    @if($errors->get('password'))
        <div class="error">
            {{ $errors->first('password') }}
        </div>
    @endif

</div>


            <!-- Confirm Password -->
            <div class="form-group">

    <label for="password_confirmation" class="form-label">
        Confirm New Password
    </label>

    <div style="position:relative; width:100%;">

        <input
            id="password_confirmation"
            class="form-input"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
            style="padding-right:45px;"
        >

        <i
            class="bi bi-eye"
            id="confirmEyeIcon"
            onclick="togglePassword('password_confirmation', 'confirmEyeIcon')"
            style="
                position:absolute;
                right:12px;
                top:50%;
                transform:translateY(-50%);
                cursor:pointer;
                font-size:18px;
                color:#777;
            "
        ></i>

    </div>

    @if($errors->get('password_confirmation'))
        <div class="error">
            {{ $errors->first('password_confirmation') }}
        </div>
    @endif

</div>


            <button type="submit" class="reset-button">
                Reset Password
            </button>

        </form>

    </div>

</div>

<script>
function togglePassword(inputId, iconId) {

    const password = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);

    if (password.type === 'password') {

        password.type = 'text';

        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');

    } else {

        password.type = 'password';

        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');

    }
}
</script>
</body>
</html>
