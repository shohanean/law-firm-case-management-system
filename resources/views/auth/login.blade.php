<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('dashboard_assets') }}/images/favicon-32x32.png" type="image/png" />
    <link href="{{ asset('dashboard_assets') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('dashboard_assets') }}/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{ asset('dashboard_assets') }}/css/style.css" rel="stylesheet" />
    <link href="{{ asset('dashboard_assets') }}/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{ asset('dashboard_assets') }}/css/pace.min.css" rel="stylesheet" />
    <title>{{ env('APP_NAME') }}</title>

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Left: full-height photo panel ── */
        .login-photo {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .login-photo img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* ── Right: form panel ── */
        .login-form-panel {
            width: 780px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 130px;
            background: #fff;
        }

        .login-form-inner {
            width: 100%;
            max-width: 520px;
        }

        .login-form-inner .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .login-form-inner .brand-logo img {
            width: 36px;
            height: 36px;
        }

        .login-form-inner .brand-logo span {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .login-form-inner h4 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a1a2e;
        }

        .login-form-inner .subtitle {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #adb5bd;
            pointer-events: none;
        }

        .input-icon-wrap .form-control {
            padding-left: 40px;
            border-radius: 8px;
        }

        .btn-signin {
            background-color: #0077BE;
            border-color: #0077BE;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .btn-signin:hover { background-color: #005f9e; border-color: #005f9e; }

        /* ── Responsive: mobile background photo ── */
        @media (max-width: 991.98px) {
            .login-wrapper {
                background-image: url('{{ asset('dashboard_assets') }}/images/error/login-img.jpg');
                background-size: cover;
                background-position: center;
            }

            .login-wrapper::before {
                content: '';
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.55);
                z-index: 0;
            }

            .login-photo { display: none; }

            .login-form-panel {
                position: relative;
                z-index: 1;
                width: 100%;
                min-height: 100vh;
                background: transparent;
                padding: 48px 24px;
                align-items: center;
            }

            .login-form-inner {
                background: #fff;
                border-radius: 16px;
                padding: 36px 32px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.35);
            }
        }

        @media (max-width: 575.98px) {
            .login-form-inner { padding: 28px 20px; }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        {{-- Left: photo --}}
        <div class="login-photo d-none d-lg-block">
            <img src="{{ asset('dashboard_assets') }}/images/error/login-img.jpg" alt="Login background">
        </div>

        {{-- Right: form --}}
        <div class="login-form-panel">
            <div class="login-form-inner">

                <div class="brand-logo">
                    <img src="{{ asset('dashboard_assets') }}/images/favicon-32x32.png" alt="Logo">
                    <span>{{ env('APP_NAME') }}</span>
                </div>

                <h4>Welcome back</h4>
                <p class="subtitle">Sign in to manage your cases</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="inputEmail" class="form-label fw-medium">Email Address</label>
                        <div class="input-icon-wrap">
                            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" id="inputEmail" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="you@example.com"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputPassword" class="form-label fw-medium">Password</label>
                        <div class="input-icon-wrap">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="inputPassword" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked>
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" id="signInBtn" class="btn btn-primary btn-signin">
                            Sign In
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="{{ asset('dashboard_assets') }}/js/jquery.min.js"></script>
    <script src="{{ asset('dashboard_assets') }}/js/pace.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('form');
            var btn  = document.getElementById('signInBtn');
            form.addEventListener('submit', function () {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Signing in…';
            });
        });
    </script>

</body>

</html>
