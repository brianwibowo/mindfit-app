<x-app-layout>
    <x-slot name="header">Manajemen Pendaftaran Klien</x-slot>

    <!-- Premium custom styles for modern UI/UX segmented tabs, table rows, and status badges -->
    <style>
        /* Shimmer loading effect */
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

        /* Image modal preview styling */
        .proof-preview-img {
            max-width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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

        /* Modern Soft Badges styling */
        .badge-soft-warning {
            background-color: rgba(255, 193, 7, 0.15);
            color: #b58100;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-soft-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: #1e7e34;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-soft-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: #bd2130;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-soft-info {
            background-color: rgba(23, 162, 184, 0.15);
            color: #117a8b;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-block;
        }

        /* Clean Table formatting */
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #ebedf2;
            padding-bottom: 12px;
        }

        /* Premium horizontal pill action button override to prevent circle squishing */
        .btn-premium-action {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 16px !important;
            border-radius: 30px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            width: auto !important;
            height: auto !important;
            line-height: 1.2 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06) !important;
            transition: all 0.2s ease !important;
            text-transform: none !important;
        }
        .btn-premium-action i {
            font-size: 0.85rem !important;
            margin-right: 4px !important;
        }
        .btn-premium-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.12) !important;
        }
    </style>

    <!-- Skeleton Shimmer Template -->
    <template id="table-skeleton-template">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TGL DAFTAR</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">KLIEN</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PAKET</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">BERAKHIR</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TOTAL</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">STATUS</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="skeleton-shimmer" style="width: 80px; height: 15px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 50px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td>
                            <div class="skeleton-shimmer" style="width: 120px; height: 15px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 100px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td><div class="skeleton-shimmer" style="width: 140px; height: 15px; border-radius: 4px;"></div></td>
                        <td><div class="skeleton-shimmer" style="width: 80px; height: 15px; border-radius: 4px;"></div></td>
                        <td><div class="skeleton-shimmer" style="width: 70px; height: 15px; border-radius: 4px;"></div></td>
                        <td><div class="skeleton-shimmer mx-auto" style="width: 80px; height: 22px; border-radius: 20px;"></div></td>
                        <td><div class="skeleton-shimmer mx-auto" style="width: 120px; height: 32px; border-radius: 20px;"></div></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </template>

    <!-- Row with mb-5 to prevent sticking/cut-off at the footer -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Daftar Pendaftaran</h3>
                            <p class="text-muted text-xs mb-0">Kelola verifikasi pendaftaran member masuk berdasarkan bukti transfer.</p>
                        </div>
                        <!-- Live Search Input -->
                        <div class="position-relative" style="min-width: 300px;">
                            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="search-input" class="form-control ps-5 rounded-pill border-1" 
                                   placeholder="Cari nama atau email klien..." value="{{ request('search') }}"
                                   style="background-color: #f8f9fa;">
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    <div class="mb-4 overflow-auto" style="white-space: nowrap; -webkit-overflow-scrolling: touch; max-width: 100%;">
                        <ul class="nav nav-pills-segmented" id="status-tabs" style="flex-wrap: nowrap; margin-bottom: 0 !important;">
                            <li class="nav-item">
                                <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" data-status="pending"
                                    href="{{ route('admin.clients.index', ['status' => 'pending']) }}">Baru (Pending)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status == 'approved' ? 'active' : '' }}" data-status="approved"
                                    href="{{ route('admin.clients.index', ['status' => 'approved']) }}">Diterima (Active)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status == 'revision' ? 'active' : '' }}" data-status="revision"
                                    href="{{ route('admin.clients.index', ['status' => 'revision']) }}">Revisi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status == 'rejected' ? 'active' : '' }}" data-status="rejected"
                                    href="{{ route('admin.clients.index', ['status' => 'rejected']) }}">Ditolak</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $status == 'all' ? 'active' : '' }}" data-status="all"
                                    href="{{ route('admin.clients.index', ['status' => 'all']) }}">Semua</a>
                            </li>
                        </ul>
                    </div>

                    {{-- TABLE CONTAINER --}}
                    <div id="clients-table-container">
                        @include('admin.clients.partials.table_body')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Bukti Transfer -->
    <div class="modal fade" id="proofPreviewModal" tabindex="-1" aria-labelledby="proofPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="proofPreviewModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-dark">
                        Klien: <strong id="proof-modal-client-name"></strong>
                    </div>
                    <img src="" id="proof-modal-image" class="proof-preview-img img-fluid" alt="Bukti Transfer">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Tutup</button>
                    <a href="" id="proof-modal-download" class="btn btn-primary btn-round" download target="_blank">
                        <i class="fa fa-download"></i> Buka Gambar Penuh
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            let activeStatus = "{{ $status }}";
            let searchQuery = "";
            let searchTimeout = null;

            // Handle Tab Clicks
            $('#status-tabs .nav-link').on('click', function (e) {
                e.preventDefault();
                $('#status-tabs .nav-link').removeClass('active');
                $(this).addClass('active');

                activeStatus = $(this).data('status');
                fetchData(1);
            });

            // Handle Search Input (debounced)
            $('#search-input').on('keyup input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchQuery = $(this).val();
                    fetchData(1);
                }, 350);
            });

            // Handle Pagination Click Handler
            $(document).on('click', '#clients-table-container .pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchData(page);
            });

            // Open Proof File Modal
            $(document).on('click', '.btn-preview-proof', function () {
                let imgUrl = $(this).data('proof');
                let clientName = $(this).data('client');

                $('#proof-modal-client-name').text(clientName);
                $('#proof-modal-image').attr('src', imgUrl);
                $('#proof-modal-download').attr('href', imgUrl);
                
                let proofModal = new bootstrap.Modal(document.getElementById('proofPreviewModal'));
                proofModal.show();
            });

            // Fetch AJAX Data Function
            function fetchData(page) {
                // Render Table Shimmer Loading Placeholder
                let skeletonHtml = $('#table-skeleton-template').html();
                $('#clients-table-container').html(skeletonHtml);

                // Update location URL
                let newUrl = window.location.pathname + '?status=' + activeStatus;
                if (searchQuery) {
                    newUrl += '&search=' + encodeURIComponent(searchQuery);
                }
                if (page > 1) {
                    newUrl += '&page=' + page;
                }
                window.history.pushState({ path: newUrl }, '', newUrl);

                $.ajax({
                    url: "{{ route('admin.clients.index') }}",
                    type: "GET",
                    data: {
                        status: activeStatus,
                        search: searchQuery,
                        page: page
                    },
                    success: function (html) {
                        $('#clients-table-container').html(html);
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        $('#clients-table-container').html(`
                            <div class="alert alert-danger text-center my-3">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                                Gagal memuat data pendaftaran. Silakan coba lagi.
                            </div>
                        `);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>