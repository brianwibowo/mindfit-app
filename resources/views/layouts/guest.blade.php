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
            background-color: #f5f7fd !important;
        }

        .wrapper-auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-auth {
            width: 100%;
            max-width: 450px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.08);
        }

        .logo-auth {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-auth img {
            max-width: 100%;
            height: auto;
        }

        .logo-auth h2 {
            font-weight: 800;
            color: #1a2035;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .btn-round {
            border-radius: 8px;
        }

        .input-group-text {
            border-right: none;
        }

        .form-control.border-start-0 {
            border-left: none;
        }

        .form-control.border-start-0:focus {
            border-left: none;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #1572e8;
            box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
        }

        .btn-primary {
            background-color: #1572e8;
            border-color: #1572e8;
        }

        .btn-primary:hover {
            background-color: #1260d0;
            border-color: #1260d0;
        }
    </style>
</head>

<body>
    <div class="wrapper-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('kaiadmin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>

</html>