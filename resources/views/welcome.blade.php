<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MindFit - Healthy for Life</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

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
        .landing-wrapper {
            background: linear-gradient(135deg, #1a2035 0%, #2a2f4c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 1.2rem;
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .btn-cta {
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 50px;
        }
    </style>
</head>

<body>
    <div class="landing-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-5 mb-md-0">
                    <div class="hero-text">
                        <h1>MINDFIT</h1>
                        <p>Platform kesehatan mental dan fisik terpadu untuk Anda. Dapatkan bimbingan dari coach
                            profesional dan capai target kebugaran Anda.</p>
                        <div class="d-flex gap-3 justify-content-center justify-content-md-start">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-cta">Ke Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary btn-cta">Masuk</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-cta">Daftar Sekarang</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('kaiadmin/img/kaiadmin/logo_light.svg') }}" alt="MindFit Logo"
                        style="max-width: 80%; opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>
</body>

</html>