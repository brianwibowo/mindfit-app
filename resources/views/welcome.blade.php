<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MindFit - Healthy for Life</title>
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
            --bg-dark: #1a2035;
            --text-light: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.65);
            --accent-glow: rgba(74, 144, 226, 0.35);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
        }

        /* ─── NAVBAR ─── */
        .navbar-custom {
            background: rgba(26, 32, 53, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0.85rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(74, 144, 226, 0.12);
        }

        .navbar-custom .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 16px;
            padding-right: 16px;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-light) !important;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.5px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .navbar-brand img {
            height: 32px;
            width: 32px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .nav-link-custom {
            color: var(--text-muted) !important;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-nav-signup {
            background: var(--primary);
            color: white !important;
            padding: 7px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            white-space: nowrap;
            display: inline-block;
        }

        /* ─── HERO ─── */
        .hero-section {
            display: flex;
            align-items: center;
            padding-top: 70px;
            padding-bottom: 48px;
            position: relative;
            overflow: hidden;
            min-height: 100svh; /* safe viewport height */
        }

        /* Glow blobs — desktop only */
        @media (min-width: 992px) {
            .hero-section::before {
                content: '';
                position: absolute;
                top: -10%;
                right: -8%;
                width: 480px;
                height: 480px;
                background: radial-gradient(circle, rgba(74, 144, 226, 0.15) 0%, transparent 65%);
                border-radius: 50%;
                pointer-events: none;
            }
            .hero-section::after {
                content: '';
                position: absolute;
                bottom: -15%;
                left: -6%;
                width: 380px;
                height: 380px;
                background: radial-gradient(circle, rgba(74, 144, 226, 0.08) 0%, transparent 65%);
                border-radius: 50%;
                pointer-events: none;
            }
        }

        /* ─── TEXT ─── */
        .badge-pill-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(74, 144, 226, 0.12);
            border: 1px solid rgba(74, 144, 226, 0.3);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 99px;
            font-size: 0.78rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
        }

        .hero-text h1 {
            /* fluid: min 1.8rem → max 3.5rem based on viewport */
            font-size: clamp(1.9rem, 5.5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.18;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .hero-text h1 span { color: var(--primary); }

        .hero-text p.lead {
            color: var(--text-muted);
            font-size: clamp(0.88rem, 2.5vw, 1.05rem);
            margin-bottom: 2rem;
            line-height: 1.72;
        }

        /* ─── BUTTONS ─── */
        .btn-group-hero {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-main {
            background-color: var(--primary);
            color: white !important;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid var(--primary);
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-main:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -5px var(--accent-glow);
        }

        .btn-outline-custom {
            background: transparent;
            color: rgba(255,255,255,0.85) !important;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid rgba(255,255,255,0.2);
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            border-color: rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.05);
            color: white !important;
        }

        /* ─── IMAGE ─── */
        .hero-image-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .hero-img-main {
            width: 100%;
            max-width: 520px;
            height: auto;
            border-radius: 18px;
            box-shadow:
                0 20px 40px -10px rgba(0,0,0,0.5),
                0 0 0 1px rgba(74,144,226,0.15);
            object-fit: cover;
            display: block;
        }

        .img-glow {
            position: absolute;
            inset: -20px;
            background: radial-gradient(ellipse at center, rgba(74,144,226,0.1) 0%, transparent 70%);
            border-radius: 32px;
            z-index: -1;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 991px) {
            .hero-section {
                padding-top: 80px;
                padding-bottom: 48px;
                min-height: auto;
            }

            .hero-text { text-align: center; }

            .badge-pill-custom {
                margin-left: auto;
                margin-right: auto;
            }

            .btn-group-hero { justify-content: center; }

            .hero-image-wrapper { margin-top: 36px; }

            .hero-img-main { max-width: 100%; border-radius: 14px; }
        }

        @media (max-width: 480px) {
            .btn-group-hero {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-main, .btn-outline-custom {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit">
                MindFit
            </a>
            
            <div class="d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav-signup">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link-custom d-none d-sm-inline">Log In</a>
                    <a href="{{ route('register') }}" class="btn-nav-signup">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center g-4">

                <div class="col-lg-6">
                    <div class="hero-text">
                        <div class="badge-pill-custom">
                            <i class="fas fa-check-circle"></i> Smart Health Platform
                        </div>

                        <h1>Train smart <br class="d-none d-lg-block"><span>Live balanced.</span></h1>

                        <p class="lead">
                            Platform penyedia kebugaran dan panduan nutrisi terpadu. Dapatkan bimbingan terarah dari Personal Trainer dan capai target impian Anda mulai hari ini.
                        </p>
                        
                        <div class="btn-group-hero">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-main">
                                    <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn-main">Mulai Sekarang</a>
                                <a href="{{ route('login') }}" class="btn-outline-custom">Masuk</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <div class="img-glow"></div>
                        <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                             alt="MindFit Training" 
                             class="hero-img-main">
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>