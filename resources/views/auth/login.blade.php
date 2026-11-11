<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary: #0F766E;
        --primary-dark: #0B5A54;
        --dark: #13262B;
        --text: #111827;
        --muted: #6b7280;
        --border: #e5e7eb;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', Arial, sans-serif;
        min-height: 100vh;
        background: #f5f8f8;
        color: var(--text);
        -webkit-font-smoothing: antialiased;
    }

    /* ================= Page: do hisse ================= */
    .login-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1.1fr 1fr;
    }

    /* ----- Left: image panel ----- */
    .login-visual {
        position: relative;
        display: flex;
        align-items: flex-end;
        padding: 56px;
        background-image:
            linear-gradient(180deg, rgba(19, 38, 43, 0) 35%, rgba(19, 38, 43, 0.88) 100%),
            url('{{ asset('assets/images/hero-image1.png') }}');
        background-size: cover;
        background-position: 85% top;
        background-repeat: no-repeat;
    }

    .login-visual-text h2 {
        margin: 0 0 12px;
        font-size: clamp(30px, 3vw, 44px);
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: -1px;
        color: #fff;
    }

    .login-visual-text h2 span {
        color: #5eead4;
    }

    .login-visual-text p {
        margin: 0;
        max-width: 420px;
        font-size: 16px;
        line-height: 1.7;
        color: #cbd5e1;
    }

    /* ----- Right: form side ----- */
    .login-form-side {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 25px;
    }

    .login-container {
        width: 100%;
        max-width: 410px;
        padding: 38px 34px;
        background: #fff;
        border: 1px solid #eef0f3;
        border-radius: 18px;
        box-shadow: 0 10px 40px rgba(19, 38, 43, 0.08);
    }

    .login-logo {
        text-align: center;
        margin-bottom: 28px;
    }

    .login-logo i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        background: #e6f4f2;
        color: var(--primary);
        border-radius: 50%;
        font-size: 28px;
        margin-bottom: 14px;
    }

    .login-logo h2 {
        margin: 0 0 8px;
        color: var(--dark);
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .login-logo p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.5;
    }

    .login-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
    }

    .login-container input {
        display: block;
        width: 100%;
        height: 48px;
        padding: 0 14px;
        margin-bottom: 20px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        font-family: inherit;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .login-container input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
    }

    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        padding-right: 46px;
    }

    .password-wrapper i {
        position: absolute;
        right: 14px;
        top: 14px;
        color: #9ca3af;
        font-size: 19px;
        cursor: pointer;
        transition: color 0.2s;
    }

    .password-wrapper i:hover {
        color: var(--primary);
    }

    .login-container button {
        width: 100%;
        height: 50px;
        margin-top: 4px;
        border: none;
        border-radius: 10px;
        background: var(--primary);
        color: #fff;
        font-family: inherit;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
    }

    .login-container button:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 118, 110, 0.35);
    }

    .forgot-password {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: var(--primary);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .error-messages {
        margin-bottom: 20px;
        padding: 12px 14px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        color: #b91c1c;
        font-size: 14px;
        line-height: 1.7;
    }

    /* ================= Responsive ================= */
    @media (max-width: 900px) {
        .login-page {
            grid-template-columns: 1fr;
        }

        .login-visual {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .login-form-side {
            padding: 16px;
        }

        .login-container {
            padding: 28px 22px;
        }
    }
</style>

<div class="login-page">

    <div class="login-visual">
        <div class="login-visual-text">
            <h2>Dress Well. <span>Feel Great.</span></h2>
            <p>Everyday fashion for men, women and kids, delivered to your door.</p>
        </div>
    </div>

    <div class="login-form-side">

        <div class="login-container">

            <div class="login-logo">
                <i class="bi bi-bag-heart-fill"></i>

                <h2>Welcome to MyShop</h2>

                <p>Login to continue your shopping</p>
            </div>

            @if ($errors->any())
                <div class="error-messages">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf

                <label for="email">Email</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                >

                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                    >

                    <i
                        class="bi bi-eye"
                        id="eyeIcon"
                        onclick="togglePassword()"
                    ></i>
                </div>

                <button type="submit">Login</button>

                <a href="{{ route('password.request') }}"
                   class="forgot-password">
                    Forgot Password?
                </a>
            </form>

        </div>

    </div>

</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

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
