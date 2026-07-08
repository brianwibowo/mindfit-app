<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MindFit - Train Smart, Life Balanced</title>
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
            --bg-gradient: linear-gradient(135deg, #1E0E3D 0%, #0F0624 100%);
            --accent-purple: #8B5CF6; /* Luminous violet for high contrast */
            --accent-purple-hover: #7C3AED;
            --accent-yellow: #FFD000;
            --accent-teal: #00B4D8; /* Slightly brighter teal for high visual impact */
            --accent-teal-hover: #0077B6;
            --text-light: #ffffff;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Hero Wrapper */
        .hero-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            padding: 24px 40px;
            z-index: 1;
        }

        /* Top Header */
        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            z-index: 20;
        }

        .logo-container {
            display: flex;
            align-items: center;
            text-decoration: none !important;
            gap: 10px;
        }

        .logo-img {
            height: 36px;
            width: auto;
            object-fit: contain;
        }

        .logo-text {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-signup {
            background-color: var(--accent-purple);
            color: #ffffff !important;
            border-radius: 30px;
            padding: 9px 26px;
            font-weight: 700;
            font-size: 0.88rem;
            border: none;
            transition: all 0.25s ease;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .btn-signup:hover {
            background-color: var(--accent-purple-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(139, 92, 246, 0.45);
        }

        .btn-login {
            background-color: transparent;
            color: #ffffff !important;
            border-radius: 30px;
            padding: 8px 24px;
            font-weight: 600;
            font-size: 0.88rem;
            border: 1.5px solid rgba(255, 255, 255, 0.7); /* More visible border */
            transition: all 0.25s ease;
            text-decoration: none !important;
        }

        .btn-login:hover {
            border-color: #ffffff;
            background-color: #ffffff;
            color: #0F0624 !important; /* Luminous invert on hover */
            transform: translateY(-1px);
        }

        /* Center Content */
        .hero-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            max-width: 780px;
            margin: auto;
            z-index: 10;
            padding: 40px 20px;
        }

        /* Heart Pill Badge */
        .smart-pill {
            border: 1px solid rgba(0, 229, 255, 0.4);
            background: rgba(0, 229, 255, 0.08);
            color: #00e5ff;
            border-radius: 30px;
            padding: 6px 18px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 28px;
            letter-spacing: 0.03em;
        }

        .smart-pill i {
            font-size: 0.88rem;
            animation: heartBeat 1.8s infinite ease-in-out;
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            14% { transform: scale(1.2); }
            28% { transform: scale(1.05); }
            42% { transform: scale(1.25); }
            70% { transform: scale(1); }
        }

        /* Titles */
        .hero-title {
            font-size: clamp(2.4rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .hero-title span {
            color: var(--accent-yellow);
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: clamp(0.95rem, 1.8vw, 1.15rem);
            max-width: 580px;
            margin: 0 auto 32px auto;
            line-height: 1.6;
        }

        /* Central CTA Button */
        .btn-cta {
            background-color: var(--accent-teal);
            color: #ffffff !important;
            border-radius: 30px;
            padding: 14px 40px;
            font-weight: 700;
            font-size: 0.98rem;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 180, 216, 0.25);
            transition: all 0.25s ease;
            text-decoration: none !important;
            display: inline-block;
        }

        .btn-cta:hover {
            background-color: var(--accent-teal-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 180, 216, 0.4);
        }

        /* Floating Images (Desktop only) */
        .floating-card {
            position: absolute;
            border-radius: 16px; /* Slightly rounder premium corners */
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.45);
            border: 2px solid rgba(255, 255, 255, 0.08);
            z-index: 5;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .floating-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Continuous micro floating animations */
        @keyframes float-top-left {
            0%, 100% { transform: translateY(0) rotate(-1deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }
        @keyframes float-top-right {
            0%, 100% { transform: translateY(0) rotate(1.2deg); }
            50% { transform: translateY(-15px) rotate(-0.8deg); }
        }
        @keyframes float-bottom-left {
            0%, 100% { transform: translateY(0) rotate(-0.5deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        @keyframes float-bottom-right {
            0%, 100% { transform: translateY(0) rotate(1deg); }
            50% { transform: translateY(-14px) rotate(-1.2deg); }
        }

        .floating-card:hover {
            animation-play-state: paused; /* Pauses floating when hovered */
            transform: scale(1.06) translateY(-5px);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.6);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Enlarged positions matching client layout exactly */
        .card-top-left {
            left: 5%;
            top: 18%;
            width: 250px;
            height: 168px;
            animation: float-top-left 6s ease-in-out infinite;
        }

        .card-top-right {
            right: 5%;
            top: 20%;
            width: 255px;
            height: 170px;
            animation: float-top-right 7s ease-in-out infinite;
        }

        .card-bottom-left {
            left: 4%;
            bottom: 18%;
            width: 260px;
            height: 175px;
            animation: float-bottom-left 8s ease-in-out infinite;
        }

        .card-bottom-right {
            right: 6%;
            bottom: 16%;
            width: 240px;
            height: 160px;
            animation: float-bottom-right 6.5s ease-in-out infinite;
        }

        /* Footer */
        .hero-footer {
            text-align: center;
            width: 100%;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.35);
            z-index: 10;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1120px) {
            .floating-card {
                display: none; /* Hide floating cards on tablet and mobile for clean reading */
            }
            .hero-container {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="hero-container">
        <!-- Header Nav -->
        <header class="header-nav">
            <a href="/" class="logo-container">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo" class="logo-img">
                <span class="logo-text">MindFit</span>
            </a>
            
            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-signup">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-login border-0 bg-transparent">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                @endauth
            </div>
        </header>

        <!-- Floating Cards (Desktop only) -->
        <div class="floating-card card-top-left">
            <img src="{{ asset('images/welcome_nutritionist.png') }}" alt="Nutritionist Consultation">
        </div>
        <div class="floating-card card-top-right">
            <img src="{{ asset('images/welcome_runner.png') }}" alt="Fitness Runner">
        </div>
        <div class="floating-card card-bottom-left">
            <img src="{{ asset('images/welcome_fitness_ball.png') }}" alt="Gym Ball Training">
        </div>
        <div class="floating-card card-bottom-right">
            <img src="{{ asset('images/welcome_dumbbells.png') }}" alt="Weight Lifting dumbbells">
        </div>

        <!-- Center Hero Block -->
        <div class="hero-center">
            <div class="smart-pill">
                <i class="fas fa-heartbeat"></i> Smart Health Platform
            </div>
            
            <h1 class="hero-title">
                Train smart<br>
                <span>Life balanced.</span>
            </h1>
            
            <p class="hero-desc">
                Dapatkan bimbingan terarah dari Personal Trainer dan Nutrisionist berpengalaman. Capai target impian Anda mulai hari ini.
            </p>
            
            @auth
                <a href="{{ route('dashboard') }}" class="btn-cta">Masuk ke Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">Daftar Gratis Sekarang</a>
            @endauth
        </div>

        <!-- Footer -->
        <footer class="hero-footer">
            <p class="mb-0">&copy; {{ date('Y') }} MindFit. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>