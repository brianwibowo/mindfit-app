<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title ?? 'Auth' }} - MindFit</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kaiadmin/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

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
        body { background-color: #f5f7fd !important; }
        .wrapper-auth { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-auth { width: 100%; max-width: 400px; border: none; box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03); }
        .logo-auth { text-align: center; margin-bottom: 20px; }
        .logo-auth h2 { font-weight: 800; color: #1a2035; }
    </style>
</head>
<body>
    <div class="wrapper-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="logo-auth">
                        <h2>MINDFIT</h2>
                        <p class="text-muted">Healthy for Life</p>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('kaiadmin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/bootstrap.min.js') }}"></script>
</body>
</html>