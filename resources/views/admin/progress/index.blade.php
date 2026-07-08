<x-app-layout>
    <x-slot name="header">Monitoring Progress Klien</x-slot>

    <!-- Modular Styles for Shimmer Animations and Premium Card Layouts -->
    <style>
        /* Shimmer Base Effect */
        .skeleton-shimmer {
            background: linear-gradient(90deg, rgba(0,0,0,0.06) 25%, rgba(0,0,0,0.12) 50%, rgba(0,0,0,0.06) 75%);
            background-size: 200% 100%;
            animation: loading-shimmer 1.5s infinite ease-in-out;
            height: 100%;
        }
        @keyframes loading-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Card Hover Animations */
        .hover-shadow {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .hover-shadow:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }

        /* Premium Segmented Control tabs style */
        .nav-pills-segmented {
            background: rgba(0, 0, 0, 0.04);
            padding: 4px;
            border-radius: 30px;
            display: inline-flex;
            border: none;
        }
        .nav-pills-segmented .nav-item {
            margin: 0;
        }
        .nav-pills-segmented .nav-link {
            border-radius: 30px !important;
            color: #575962 !important;
            background: transparent !important;
            border: none !important;
            padding: 8px 20px !important;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .nav-pills-segmented .nav-link.active {
            background: #5c55e3 !important; /* Premium brand purple */
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(92, 85, 227, 0.25) !important;
        }
    </style>

    <!-- SKELETON PLACEHOLDERS -->
    
    <!-- 1. Table skeleton template (for unreviewed logs) -->
    <template id="table-skeleton-template">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal Input</th>
                        <th>Klien</th>
                        <th>Tipe Log</th>
                        <th>Data Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="skeleton-shimmer" style="width: 100px; height: 16px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 60px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td>
                            <div class="skeleton-shimmer" style="width: 120px; height: 16px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 100px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td><div class="skeleton-shimmer" style="width: 70px; height: 22px; border-radius: 10px;"></div></td>
                        <td><div class="skeleton-shimmer" style="width: 250px; height: 16px; border-radius: 4px;"></div></td>
                        <td><div class="skeleton-shimmer" style="width: 110px; height: 30px; border-radius: 20px;"></div></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </template>

    <!-- 2. Grid cards skeleton template (for clients view) -->
    <template id="cards-skeleton-template">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @for($i = 0; $i < 4; $i++)
            <div class="col mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #ffffff;">
                    <div style="height: 180px; background: #f5f5f7; display: flex; align-items: center; justify-content: center;">
                        <div class="skeleton-shimmer" style="width: 100%; height: 100%;"></div>
                    </div>
                    <div class="card-body p-3">
                        <div class="skeleton-shimmer mb-2" style="width: 70%; height: 18px; border-radius: 4px;"></div>
                        <div class="skeleton-shimmer mb-3" style="width: 50%; height: 12px; border-radius: 4px;"></div>
                        <div class="d-flex gap-2 mb-3">
                            <div class="skeleton-shimmer" style="width: 80px; height: 20px; border-radius: 20px;"></div>
                            <div class="skeleton-shimmer" style="width: 80px; height: 20px; border-radius: 20px;"></div>
                        </div>
                        <div class="skeleton-shimmer" style="width: 100%; height: 45px; border-radius: 6px;"></div>
                    </div>
                    <div class="card-footer p-3 bg-transparent border-0 pt-0">
                        <div class="skeleton-shimmer" style="width: 100%; height: 32px; border-radius: 20px;"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </template>

    <!-- MAIN VIEW LAYOUT -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0 border-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h4 class="card-title fw-bold">Monitoring Progres Perkembangan Klien</h4>
                            <p class="text-muted text-xs">Pantau laporan ukuran fisik harian klien dan feedback coach pengampu.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    {{-- DUAL VIEW NAVIGATION TABS (Segmented Control style) --}}
                    <ul class="nav nav-pills-segmented mb-4" id="view-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $view == 'recent' ? 'active' : '' }}" data-view="recent"
                                href="{{ route('admin.progress.index', ['view' => 'recent']) }}">
                                <i class="fa fa-clock me-1"></i> Log Terbaru (Belum Review)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $view == 'clients' ? 'active' : '' }}" data-view="clients"
                                href="{{ route('admin.progress.index', ['view' => 'clients']) }}">
                                <i class="fa fa-users me-1"></i> Ringkasan per Klien (Grouped)
                            </a>
                        </li>
                    </ul>

                    {{-- DYNAMIC DATA WRAPPER --}}
                    <div id="progress-data-container">
                        @include('admin.progress.partials.tab_content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            let activeView = "{{ $view }}";

            // Event handler for tab changes
            $('#view-tabs .nav-link').on('click', function (e) {
                e.preventDefault();
                $('#view-tabs .nav-link').removeClass('active');
                $(this).addClass('active');

                activeView = $(this).data('view');
                fetchTabContent(1);
            });

            // Event delegation to capture dynamic pagination clicks
            $(document).on('click', '#progress-data-container .pagination a', function (e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                let page = pageUrl.split('page=')[1];
                fetchTabContent(page);
            });

            // Fetch dynamic tab data
            function fetchTabContent(page) {
                // Determine and inject proper skeleton template depending on active view
                let skeletonTemplateId = activeView === 'clients' ? '#cards-skeleton-template' : '#table-skeleton-template';
                let skeletonHtml = $(skeletonTemplateId).html();
                $('#progress-data-container').html(skeletonHtml);

                // Update the address bar query parameter for deep-linking support
                let updatedUrl = window.location.pathname + '?view=' + activeView;
                if (page > 1) {
                    updatedUrl += '&page=' + page;
                }
                window.history.pushState({ path: updatedUrl }, '', updatedUrl);

                // Request partial HTML from controller
                $.ajax({
                    url: "{{ route('admin.progress.index') }}",
                    type: "GET",
                    data: {
                        view: activeView,
                        page: page
                    },
                    success: function (partialHtml) {
                        $('#progress-data-container').html(partialHtml);
                    },
                    error: function (xhr) {
                        console.error("AJAX Error loading progress logs:", xhr);
                        $('#progress-data-container').html(`
                            <div class="alert alert-danger text-center my-4 py-4">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i><br>
                                <h5>Gagal memuat data progress.</h5>
                                <p class="text-sm mb-0">Silakan muat ulang halaman atau coba beberapa saat lagi.</p>
                            </div>
                        `);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>