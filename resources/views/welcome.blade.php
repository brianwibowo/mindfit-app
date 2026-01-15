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
            google: { families: ["Public Sans:300,400,500,600,700"] },
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
        body {
            overflow-x: hidden;
        }
        
        .landing-wrapper {
            background: linear-gradient(135deg, #1a2035 0%, #2a3f5f 50%, #1a2035 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .landing-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(74, 144, 226, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .landing-wrapper::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(124, 77, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .logo-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .logo-brand img {
            height: 60px;
            width: 60px;
            object-fit: contain;
        }
        
        .logo-brand h2 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }
        
        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-text .tagline {
            font-size: 1.3rem;
            font-weight: 500;
            color: #4a90e2;
            margin-bottom: 20px;
        }
        
        .hero-text p {
            font-size: 1.1rem;
            opacity: 0.85;
            margin-bottom: 35px;
            line-height: 1.7;
        }
        
        .btn-cta {
            padding: 14px 35px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .btn-cta.btn-primary {
            background: #4a90e2;
            border-color: #4a90e2;
        }
        
        .btn-cta.btn-primary:hover {
            background: #357abd;
            border-color: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }
        
        .btn-cta.btn-outline-light {
            border-color: white;
            color: white;
        }
        
        .btn-cta.btn-outline-light:hover {
            background: white;
            color: #1a2035;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }
        
        .hero-image {
            text-align: center;
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-image img {
            max-width: 85%;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.2rem;
            }
            
            .hero-text .tagline {
                font-size: 1.1rem;
            }
            
            .hero-text p {
                font-size: 1rem;
            }
            
            .logo-brand {
                justify-content: center;
            }
            
            .logo-brand img {
                height: 50px;
                width: 50px;
            }
            
            .logo-brand h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-wrapper">
        <div class="container content-wrapper">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-5 mb-md-0">
                    <div class="hero-text">
                        <div class="logo-brand">
                            <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo">
                            <h2>MINDFIT</h2>
                        </div>
                        
                        <h1>Mulai Perjalanan Sehatmu</h1>
                        <p class="tagline">Healthy for Life</p>
                        <p>Platform kesehatan nutrisi dan fisik terpadu untuk Anda. Dapatkan bimbingan dari coach profesional dan capai target kebugaran impian Anda.</p>
                        
                        <div class="d-flex gap-3 justify-content-center justify-content-md-start flex-wrap">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-cta">
                                    <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-cta">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-cta">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Gratis
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="hero-image">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Illustration">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>