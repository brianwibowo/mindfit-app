<x-app-layout>
    <x-slot name="header">Manajemen Paket</x-slot>

    <!-- Skeletons Template (hidden helper) -->
    <template id="skeletons-template">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cvr</th>
                        <th>Nama Paket</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <div class="skeleton-shimmer rounded" style="width: 45px; height: 45px; background: rgba(0,0,0,0.06);"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer rounded mb-1" style="width: 140px; height: 16px; background: rgba(0,0,0,0.06);"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer rounded" style="width: 80px; height: 20px; background: rgba(0,0,0,0.06); border-radius: 10px;"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer rounded" style="width: 100px; height: 16px; background: rgba(0,0,0,0.06);"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer rounded" style="width: 80px; height: 16px; background: rgba(0,0,0,0.06);"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer rounded" style="width: 70px; height: 20px; background: rgba(0,0,0,0.06); border-radius: 10px;"></div>
                            </td>
                            <td class="text-center">
                                <div class="skeleton-shimmer rounded mx-auto" style="width: 75px; height: 28px; background: rgba(0,0,0,0.06);"></div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </template>

    <!-- Custom CSS for Shimmer Animation and Premium Segmented Controls -->
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .skeleton-shimmer {
            animation: pulse 1.5s infinite ease-in-out;
        }

        /* Segmented control tabs style */
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
            padding: 6px 18px !important;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .nav-pills-segmented .nav-link.active {
            background: #5c55e3 !important; /* Brand Violet */
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2) !important;
        }

        /* Premium table adjustments */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            font-size: 0.72rem !important;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 700;
            color: #8d94a5;
            border-bottom-width: 1px !important;
            background-color: rgba(0, 0, 0, 0.01) !important;
            padding: 14px 16px !important;
        }
        .table tbody td {
            padding: 14px 16px !important;
            vertical-align: middle;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header pb-3 bg-white" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 24px;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Daftar Paket MindFit</h4>
                            <p class="text-muted text-xs mb-0">Kelola paket layanan konsultasi, harga, durasi aktif, dan status program.</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary btn-round btn-sm px-3.5 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                                <i class="fa fa-plus me-1.5"></i> Buat Paket Baru
                            </button>
                        </div>
                    </div>
                    
                    {{-- DUAL VIEW NAVIGATION TABS (Segmented Control style) --}}
                    <ul class="nav nav-pills-segmented mt-3" id="filter-tabs">
                        <li class="nav-item">
                            <a class="nav-link filter-btn filter-all {{ !request('type') ? 'active' : '' }}" 
                               href="{{ route('admin.packages.index') }}">
                                Semua
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link filter-btn filter-fitness {{ request('type') == 'fitness' ? 'active' : '' }}" 
                               href="{{ route('admin.packages.index', ['type' => 'fitness']) }}">
                                Fitness
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link filter-btn filter-nutritionist {{ request('type') == 'nutritionist' ? 'active' : '' }}" 
                               href="{{ route('admin.packages.index', ['type' => 'nutritionist']) }}">
                                Nutritionist
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div id="packages-table-container">
                        @include('admin.packages.partials.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 1: ADD PACKAGE -->
    <div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title fw-bold" id="addPackageModalLabel"><i class="fas fa-plus-circle me-2"></i>Buat Paket Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" id="createPackageForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_name" class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="create_name" class="form-control" placeholder="Contoh: Paket Fat Loss 1 Bulan" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_type" class="form-label fw-bold">Tipe Program <span class="text-danger">*</span></label>
                                <select name="type" id="create_type" class="form-select" required>
                                    <option value="fitness">Fitness (Personal Trainer)</option>
                                    <option value="nutritionist">Nutritionist (Ahli Gizi)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_price" class="form-label fw-bold">Harga Paket (Rupiah) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="create_price" class="form-control" placeholder="Contoh: 350000" min="0" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_duration" class="form-label fw-bold">Durasi Aktif (Hari) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" id="create_duration" class="form-control" placeholder="Contoh: 30" min="1" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_description" class="form-label fw-bold">Deskripsi Layanan & Benefit <span class="text-danger">*</span></label>
                            <textarea name="description" id="create_description" rows="3" class="form-control" placeholder="Tuliskan detail layanan, konsultasi harian, benefit, dll." required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_images" class="form-label fw-bold">Unggah Gambar Sampul / Banner Paket</label>
                            <input type="file" name="images[]" id="create_images" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Format: jpeg, png, jpg, gif (Max 5MB). Bisa pilih lebih dari 1 gambar.</small>
                            <div class="d-flex flex-wrap gap-2 mt-3" id="create_images_preview_box"></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Simpan Paket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: DETAIL PACKAGE (WITH EMBEDDED EDIT & DELETE ACTIONS) -->
    <div class="modal fade" id="detailPackageModal" tabindex="-1" aria-labelledby="detailPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title fw-bold" id="detailPackageModalLabel">Detail Paket Layanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- 2.1 READ VIEW (DEFAULT VIEW) -->
                <div id="readPackageView">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Left column: image cover -->
                            <div class="col-md-5 text-center">
                                <div class="rounded shadow-sm overflow-hidden bg-light mx-auto" style="width: 100%; max-width: 280px; height: 180px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0,0,0,0.06);">
                                    <img id="read_image" src="" alt="Cover" class="w-100 h-100" style="object-fit: cover; display: none;">
                                    <div id="read_image_placeholder" class="text-muted py-5">
                                        <i class="fas fa-image fa-3x opacity-25"></i>
                                        <small class="d-block mt-2">Tidak ada gambar</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right column: text details -->
                            <div class="col-md-7">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="fw-bold text-dark mb-0" id="read_name">Nama Paket</h4>
                                    <span class="badge" id="read_status_badge">Status</span>
                                </div>
                                <span class="badge mb-3" id="read_type_badge">Tipe</span>
                                
                                <hr class="my-2" style="opacity: 0.1;">
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Harga Paket</small>
                                        <span class="fw-bold text-success" id="read_price" style="font-size: 1.1rem;">Rp 0</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Durasi Aktif</small>
                                        <span class="fw-bold text-dark" id="read_duration" style="font-size: 1rem;">0 Hari</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Deskripsi & Layanan</small>
                                    <p class="text-dark mb-0" id="read_description" style="font-size: 0.85rem; line-height: 1.5; white-space: pre-line;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light d-flex justify-content-between" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <div>
                            <!-- Delete Form (with confirmation) -->
                            <form id="deletePackageForm" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('PENTING: Apakah Anda yakin ingin menghapus paket ini secara permanen?')">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus Paket
                                </button>
                            </form>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" id="btnSwitchToEdit">
                                <i class="fas fa-edit me-1"></i> Edit Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2.2 EDIT VIEW (HIDDEN BY DEFAULT) -->
                <form id="updatePackageForm" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_name" class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_type" class="form-label fw-bold">Tipe Program <span class="text-danger">*</span></label>
                                <select name="type" id="edit_type" class="form-select" required>
                                    <option value="fitness">Fitness (Personal Trainer)</option>
                                    <option value="nutritionist">Nutritionist (Ahli Gizi)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_price" class="form-label fw-bold">Harga Paket (Rupiah) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="edit_price" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_duration" class="form-label fw-bold">Durasi Aktif (Hari) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" id="edit_duration" class="form-control" min="1" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_is_active" class="form-label fw-bold">Status Keaktifan <span class="text-danger">*</span></label>
                                <select name="is_active" id="edit_is_active" class="form-select" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_description" class="form-label fw-bold">Deskripsi Layanan & Benefit <span class="text-danger">*</span></label>
                            <textarea name="description" id="edit_description" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_images" class="form-label fw-bold">Unggah Gambar Baru (Menggantikan Gambar Lama)</label>
                            <input type="file" name="images[]" id="edit_images" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            <div class="d-flex flex-wrap gap-2 mt-3" id="edit_images_preview_box"></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <button type="button" class="btn btn-secondary btn-sm px-3" id="btnSwitchToRead">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Shimmer Animation -->
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .skeleton-shimmer {
            animation: pulse 1.5s infinite ease-in-out;
        }
    </style>

    @push('scripts')
    <script>
        let currentPackageObj = null;

        $(document).ready(function() {
            // Function to load packages via AJAX
            function loadPackages(url) {
                $('#packages-table-container').html($('#skeletons-template').html());

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        setTimeout(function() {
                            $('#packages-table-container').html(data);
                        }, 300);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading packages:", error);
                        $('#packages-table-container').html('<div class="text-center py-5"><p class="text-danger">Gagal memuat data paket. Silakan coba lagi.</p></div>');
                    }
                });
            }

            // Pagination dynamic link clicks
            $(document).on('click', '#packages-table-container .pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                loadPackages(url);
                window.history.pushState({path: url}, '', url);
            });

            // Filter button clicks
            $(document).on('click', '.filter-btn', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                loadPackages(url);
                window.history.pushState({path: url}, '', url);
            });

            // Handle browser back and forward actions
            window.onpopstate = function(event) {
                loadPackages(window.location.href);
            };

            // Image uploads preview - Create Modal
            $('#create_images').on('change', function(e) {
                $('#create_images_preview_box').html('');
                const files = e.target.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = $('<img>').attr('src', event.target.result)
                                                  .css({
                                                      width: '60px',
                                                      height: '60px',
                                                      objectFit: 'cover',
                                                      borderRadius: '6px',
                                                      border: '1px solid rgba(0,0,0,0.1)'
                                                  });
                            $('#create_images_preview_box').append(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Image uploads preview - Edit Modal
            $('#edit_images').on('change', function(e) {
                $('#edit_images_preview_box').html('');
                const files = e.target.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = $('<img>').attr('src', event.target.result)
                                                  .css({
                                                      width: '60px',
                                                      height: '60px',
                                                      objectFit: 'cover',
                                                      borderRadius: '6px',
                                                      border: '1px solid rgba(0,0,0,0.1)'
                                                  });
                            $('#edit_images_preview_box').append(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Read view modal switcher
            $('#btnSwitchToEdit').on('click', function() {
                if (!currentPackageObj) return;
                const p = currentPackageObj;

                // Populate Edit inputs
                $('#edit_name').val(p.name);
                $('#edit_type').val(p.type);
                $('#edit_price').val(p.price);
                $('#edit_duration').val(p.duration_days);
                $('#edit_description').val(p.description);
                $('#edit_is_active').val(p.is_active ? '1' : '0');
                
                // Clear file input & previews
                $('#edit_images').val('');
                $('#edit_images_preview_box').html('');

                $('#readPackageView').hide();
                $('#updatePackageForm').show();
                $('#detailPackageModalLabel').text('Edit Paket Layanan');
            });

            $('#btnSwitchToRead').on('click', function() {
                $('#updatePackageForm').hide();
                $('#readPackageView').show();
                $('#detailPackageModalLabel').text('Detail Paket Layanan');
            });
        });

        // AJAX loader for Detail Modal (Read view)
        function viewPackageDetail(id) {
            $.ajax({
                url: `/admin/packages/${id}`,
                method: 'GET',
                success: function(p) {
                    currentPackageObj = p;

                    // Text values
                    $('#read_name').text(p.name);
                    $('#read_price').text('Rp ' + parseInt(p.price).toLocaleString('id-ID'));
                    $('#read_duration').text(p.duration_days + ' Hari');
                    $('#read_description').text(p.description);

                    // Type badge
                    if (p.type === 'fitness') {
                        $('#read_type_badge').text('Fitness (PT)').removeClass().addClass('badge bg-primary text-white');
                    } else {
                        $('#read_type_badge').text('Nutritionist').removeClass().addClass('badge bg-warning text-dark');
                    }

                    // Status badge
                    if (p.is_active) {
                        $('#read_status_badge').text('Aktif').removeClass().addClass('badge bg-success text-white');
                    } else {
                        $('#read_status_badge').text('Non-Aktif').removeClass().addClass('badge bg-danger text-white');
                    }

                    // Image cover preview
                    if (p.image_url) {
                        $('#read_image').attr('src', p.image_url).show();
                        $('#read_image_placeholder').hide();
                    } else {
                        $('#read_image').attr('src', '').hide();
                        $('#read_image_placeholder').show();
                    }

                    // Set action routes
                    $('#deletePackageForm').attr('action', `/admin/packages/${id}`);
                    $('#updatePackageForm').attr('action', `/admin/packages/${id}`);

                    // Reset to read-only view
                    $('#updatePackageForm').hide();
                    $('#readPackageView').show();
                    $('#detailPackageModalLabel').text('Detail Paket Layanan');

                    // Show Modal
                    const detailModal = new bootstrap.Modal(document.getElementById('detailPackageModal'));
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal mengambil data rincian paket.');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>