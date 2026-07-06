<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title ?? 'Auth' }} - MindFit</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}?v=2" type="image/x-icon" />

    <script src="{{ asset('kaiadmin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Plus Jakarta Sans:300,400,500,600,700,800"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["{{ asset('kaiadmin/css/fonts.min.css') }}"],
            },
            active: function () { sessionStorage.fonts = true; },
        });
    </script>

    <link rel="stylesheet" href="{{ asset('kaiadmin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/kaiadmin.min.css') }}" />

    <style>
        :root {
            --primary: #4a90e2;
            --primary-hover: #357abd;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ─── FULL-SCREEN IMMERSIVE BACKGROUND ─── */
        .auth-page {
            position: relative;
            width: 100%;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .auth-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .auth-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Dark gradient overlay for readability */
        .auth-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(10, 14, 26, 0.92) 0%,
                rgba(15, 23, 42, 0.82) 40%,
                rgba(26, 32, 53, 0.75) 100%
            );
        }

        /* ─── GLASSMORPHISM CARD ─── */
        .auth-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            padding: 28px 24px;
            box-shadow:
                0 20px 40px -15px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
        }


        /* ─── FORM ELEMENTS ─── */
        .auth-card .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .auth-card .input-group {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
            border: 1.5px solid var(--border-color);
            background: #f8fafc;
        }

        .auth-card .input-group-text {
            background: transparent !important;
            border: none;
            color: #94a3b8;
            padding: 10px 14px;
            transition: color 0.2s ease;
        }

        .auth-card .form-control {
            background: transparent !important;
            border: none;
            color: var(--text-dark) !important;
            padding: 10px 14px 10px 0;
            font-size: 0.88rem;
            height: auto;
        }

        .auth-card .form-control::placeholder {
            color: #a0aec0;
        }

        .auth-card .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.12);
            background: #ffffff;
        }

        .auth-card .input-group:focus-within .input-group-text {
            color: var(--primary);
        }

        .auth-card .form-control:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        /* ─── BUTTONS ─── */
        .auth-card .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 700 !important;
            font-size: 0.92rem !important;
            transition: all 0.25s ease !important;
            letter-spacing: 0.2px;
        }

        .auth-card .btn-primary:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 6px 18px rgba(74, 144, 226, 0.25) !important;
        }

        .auth-card .btn-primary:active {
            transform: translateY(0);
        }

        .auth-card .text-primary {
            color: var(--primary) !important;
            font-weight: 600;
        }

        .auth-card .text-primary:hover {
            color: var(--primary-hover) !important;
        }

        .auth-card .form-check-input:checked {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* ─── RESPONSIVE ─── */

        /* Mobile (< 576px) */
        @media (max-width: 575.98px) {
            .auth-page {
                padding: 16px 12px;
                align-items: center; /* Center vertically on mobile */
            }

            .auth-card {
                border-radius: 18px;
                padding: 24px 18px; /* Tighter padding on mobile */
                max-width: 100% !important; /* Force full width within constraints on mobile */
            }
        }

        /* Tablet (576px - 991px) */
        @media (min-width: 576px) and (max-width: 991.98px) {
            .auth-card {
                padding: 32px 24px;
            }
        }

        /* Desktop (992px+) */
        @media (min-width: 992px) {
            .auth-card {
                padding: 48px 36px; /* Generous padding: wide and tall! */
                max-width: 500px;
            }
        }
    </style>
</head>

<body>
    <!-- Full-Screen Gym Background Image -->
    <div class="auth-bg">
        <img src="{{ asset('images/strong-man-training-gym.webp') }}"
             alt="MindFit Gym Background">
    </div>

    <!-- Auth Page Container -->
    <div class="auth-page">
        {{ $slot }}
    </div>

    <script src="{{ asset('kaiadmin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>

</html>