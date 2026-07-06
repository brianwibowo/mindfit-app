<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MindFit - App Portal</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}" type="image/x-icon" />
    
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
            --border-color: rgba(255, 255, 255, 0.15);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        /* Full-Screen Immersive Background */
        .portal-page {
            position: relative;
            width: 100%;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 1;
        }

        .portal-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .portal-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 70%; /* Shift image up so training people are visible */
        }

        /* Dark overlay for readability */
        .portal-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(15, 23, 42, 0.95) 0%,
                rgba(30, 41, 59, 0.85) 50%,
                rgba(15, 23, 42, 0.95) 100%
            );
        }

        /* Portal Glass Card */
        .portal-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 28px;
            padding: 40px 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            text-align: center;
            color: var(--text-dark);
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-portal {
            height: 80px;
            width: 80px;
            object-fit: contain;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 15px rgba(74, 144, 226, 0.2));
            animation: pulse 3s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .portal-title {
            font-size: clamp(1.6rem, 5vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .portal-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Buttons */
        .btn-portal-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            border: none;
            color: #ffffff !important;
            border-radius: 14px;
            padding: 14px 28px;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(74, 144, 226, 0.25);
            text-decoration: none !important;
            width: 100%;
            margin-bottom: 14px;
        }

        .btn-portal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(74, 144, 226, 0.4);
        }

        .btn-portal-outline {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: var(--text-dark) !important;
            border-radius: 14px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            text-decoration: none !important;
            width: 100%;
            margin-bottom: 14px;
        }

        .btn-portal-outline:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        /* Divider (Fixed to show grey line on left/right of 'ATAU') */
        .divider {
            height: 1px;
            background: #cbd5e1;
            margin: 25px 0;
            position: relative;
        }

        .divider::after {
            content: 'ATAU';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            padding: 0 12px;
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 4px;
        }

        .btn-back-main {
            color: var(--text-muted) !important;
            text-decoration: none !important;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 30px;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
            background: #f1f5f9;
            margin-top: 10px;
        }

        .btn-back-main:hover {
            color: var(--text-dark) !important;
            border-color: #94a3b8;
            background: #e2e8f0;
            transform: translateX(-2px);
        }

        /* Responsive Mobile adjustment */
        @media (max-width: 480px) {
            .portal-card {
                padding: 30px 20px;
                border-radius: 20px;
            }
            .portal-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="portal-page">
        <!-- Full-Screen Gym/Fitness Background -->
        <div class="portal-bg">
            <img src="{{ asset('images/people-training-gym-full-shot.webp') }}" 
                 alt="MindFit Training Room">
        </div>

        <!-- Central Portal Glass Card -->
        <div class="portal-card">
            <!-- Brand Logo -->
            <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo" class="logo-portal">
            
            <h1 class="portal-title">MindFit Portal</h1>
            <p class="portal-subtitle">
                Akses aplikasi coaching, pantau log perkembangan fisik harian, dan jalankan analisis kesehatan berbasis AI.
            </p>

            @auth
                <!-- User is authenticated -->
                <a href="{{ route('dashboard') }}" class="btn-portal-primary">
                    <i class="fas fa-tachometer-alt"></i> Masuk ke Dashboard
                </a>
            @else
                <!-- Guest users -->
                <a href="{{ route('login') }}" class="btn-portal-primary">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Akun
                </a>
                
                <a href="{{ route('register') }}" class="btn-portal-outline">
                    <i class="fas fa-user-plus"></i> Daftar Klien Baru
                </a>
            @endauth

            <div class="divider"></div>

            <!-- Back to marketing main domain -->
            <a href="https://mindfit.id" target="_blank" rel="noopener noreferrer" class="btn-back-main">
                <i class="fas fa-arrow-left"></i> Kembali ke mindfit.id
            </a>
        </div>
    </div>

</body>
</html>