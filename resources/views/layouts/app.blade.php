<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $header ?? 'Dashboard' }} - MindFit</title>
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
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dark-theme.css') }}" />
    <!-- Driver.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    
    <!-- Theme Initialization Script (Prevent White Flashing) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'system';
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    @if(Auth::check() && Auth::user()->gender === 'female')
        <link rel="stylesheet" href="{{ asset('css/female-theme.css') }}" />
    @endif
    <style>
        /* ─── Flexbox layout for sticky footer ─── */
        .main-panel {
            min-height: 100vh !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
            padding-bottom: 0 !important;
        }

        .main-panel > .container, 
        .main-panel > .container-full {
            margin-top: 52px !important;
            flex: 1 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            min-width: 0 !important;
            overflow-x: auto !important;
        }

        .main-panel > .container > .page-inner {
            flex: 1 0 auto !important;
            min-width: 0 !important;
            overflow-x: auto !important;
        }

        /* ─── Force card content to stay within viewport ─── */
        .page-inner .card {
            max-width: 100% !important;
        }
        .page-inner .card > .card-header,
        .page-inner .card > .card-body {
            max-width: 100% !important;
            overflow-x: auto !important;
        }
        .page-inner h3,
        .page-inner h4,
        .page-inner .card-title {
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }

        /* ─── Global table responsive fix ─── */
        .table-responsive {
            overflow-x: auto !important;
        }
        .table-responsive > .table {
            min-width: 700px;
        }

        /* ─── Global nav-pills / tab bar scroll fix ─── */
        .nav-pills,
        .nav-tabs {
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .nav-pills::-webkit-scrollbar,
        .nav-tabs::-webkit-scrollbar {
            display: none;
        }

        @media (max-width: 767px) {
            .page-inner .card-header .d-flex {
                flex-wrap: wrap !important;
            }
        }

        /* ─── Global Pagination Layout Fix ─── */
        /* Force page numbers and pagination info to always be visible on mobile instead of hiding them */
        nav[role="navigation"] .d-flex.justify-content-between.flex-fill.d-sm-none {
            display: none !important;
        }
        nav[role="navigation"] .d-none.flex-sm-fill.d-sm-flex {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 12px;
        }
        @media (min-width: 576px) {
            nav[role="navigation"] .d-none.flex-sm-fill.d-sm-flex {
                flex-direction: row !important;
                justify-content: space-between !important;
            }
        }

        /* ─── Footer styling (standard static block pushed to bottom) ─── */
        .footer {
            position: static !important;
            margin-top: auto !important;
            width: 100% !important;
            padding: 20px 25px !important;
            background: #fff !important;
            border-top: 1px solid #eee !important;
            z-index: 5;
        }

        /* ─── Dark-mode footer ─── */
        [data-theme="dark"] .footer {
            background: #1f283e !important;
            border-top-color: #293247 !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.sidebar')

        <div class="main-panel">
            <div class="main-header" style="min-height: 52px !important; height: 52px !important;">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="#" class="logo">
                            <img src="{{ asset('storage/images/logo.png') }}" alt="navbar brand" class="navbar-brand"
                                height="30" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                        </div>
                    </div>
                </div>
                @include('layouts.partials.header')
            </div>

            <div class="container">
                <div class="page-inner">
                    @include('layouts.partials.alerts')
                    {{ $slot }}
                </div>
            </div>

            @include('layouts.partials.footer')
        </div>
    </div>

    <script src="{{ asset('kaiadmin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script>
        // Global AJAX setup to bypass ngrok warning pages for dynamic AJAX elements
        $.ajaxSetup({
            headers: {
                'ngrok-skip-browser-warning': 'true'
            }
        });
    </script>
    <script src="{{ asset('kaiadmin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/js/kaiadmin.min.js') }}"></script>
    
    <!-- Driver.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    
    <!-- Include Help Center Accordion & Onboarding scripts -->
    @include('layouts.partials.help_and_tour')
    
    @stack('scripts')
</body>

</html>