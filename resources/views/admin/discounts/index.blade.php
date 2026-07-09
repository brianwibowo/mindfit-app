<x-app-layout>
    <x-slot name="header">Manajemen Diskon</x-slot>

    <!-- Custom CSS for Premium Design Elements -->
    <style>
        .table-responsive {
            border-radius: 8px;
            overflow-x: auto !important;
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
        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border-radius: 8px !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            padding: 10px 14px !important;
            font-size: 0.85rem !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5c55e3 !important;
            box-shadow: 0 0 0 3px rgba(92, 85, 227, 0.15) !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header pb-3 bg-white" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 24px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Daftar Voucher Diskon</h4>
                            <p class="text-muted text-xs mb-0">Kelola voucher promo untuk pendaftaran paket klien.</p>
                        </div>
                        <button class="btn btn-primary btn-round btn-sm px-3.5 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addDiscountModal">
                            <i class="fas fa-plus me-1.5"></i> Tambah Diskon Baru
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 850px;">
                            <thead>
                                <tr>
                                    <th>Kode Promo</th>
                                    <th>Jenis Potongan</th>
                                    <th>Nilai Potongan</th>
                                    <th>Batas Maksimal</th>
                                    <th>Masa Berlaku</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discounts as $d)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary" style="font-size: 0.95rem;">{{ $d->code }}</span>
                                        </td>
                                        <td>
                                            @if($d->type == 'percent')
                                                <span class="badge text-info" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(29, 122, 243, 0.08);">Persentase (%)</span>
                                            @else
                                                <span class="badge text-secondary" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(141, 148, 165, 0.08);">Nominal (Rp)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold" style="font-size: 0.88rem;">
                                                {{ $d->type == 'percent' ? $d->value . '%' : 'Rp ' . number_format($d->value, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($d->max_limit)
                                                <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">Rp {{ number_format($d->max_limit, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted" style="font-size: 0.85rem;">Tidak Terbatas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($d->start_date || $d->end_date)
                                                <span class="text-secondary fw-semibold" style="font-size: 0.82rem;">
                                                    {{ $d->start_date ? $d->start_date->format('d M Y') : 'Selamanya' }} - 
                                                    {{ $d->end_date ? $d->end_date->format('d M Y') : 'Selamanya' }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-muted border" style="font-size: 0.7rem; padding: 4px 8px;">Selamanya</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($d->is_active)
                                                <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                                                    <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #2ecc71; vertical-align: middle; margin-top: -2px;"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                                    <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #e74c3c; vertical-align: middle; margin-top: -2px;"></span>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-xs fw-semibold px-3 py-1.5" style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;" onclick="viewDiscountDetail({{ $d->id }})" onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-percent fa-2x mb-2 opacity-50"></i><br>
                                            Belum ada kode diskon yang dibuat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {!! $discounts->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD DISCOUNT (WIDER & RESPONSIVE GRID) -->
    <div class="modal fade" id="addDiscountModal" tabindex="-1" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 14px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #5c55e3; padding: 16px 24px; border: none;">
                    <h5 class="modal-title fw-bold" id="addDiscountModalLabel">
                        <i class="fas fa-plus-circle me-2"></i> Buat Voucher Diskon Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.discounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <!-- Row 1: Code and Status -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="code" class="form-label">Kode Voucher <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control" placeholder="Contoh: MINDFIT15" required style="text-transform: uppercase;">
                                <small class="text-muted" style="font-size: 0.72rem;">Gunakan huruf kapital tanpa spasi.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="is_active" class="form-label">Status Voucher <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-select" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Type and Value -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="type" class="form-label">Jenis Potongan <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="percent">Persentase (%)</option>
                                    <option value="nominal">Nominal (Rupiah)</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="value" class="form-label">Nilai Potongan <span class="text-danger">*</span></label>
                                <input type="number" name="value" class="form-control" placeholder="Contoh: 10 atau 50000" min="1" required>
                            </div>
                        </div>

                        <!-- Row 3: Max limit and Min purchase -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="max_limit" class="form-label">Batas Potongan Maksimal (Rp)</label>
                                <input type="number" name="max_limit" class="form-control" placeholder="Kosongkan jika tak terbatas">
                                <small class="text-muted" style="font-size: 0.72rem;">Hanya berlaku untuk tipe persentase (%).</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="min_purchase" class="form-label">Minimal Pembelian (Rp)</label>
                                <input type="number" name="min_purchase" class="form-control" placeholder="Kosongkan jika tidak ada" min="0">
                            </div>
                        </div>

                        <!-- Row 4: Dates -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="start_date" class="form-label">Tanggal Mulai Berlaku</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="end_date" class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>

                        <!-- Row 5: Max uses -->
                        <div class="row g-3">
                            <div class="col-md-6 form-group">
                                <label for="max_uses" class="form-label">Kuota Penggunaan (Orang)</label>
                                <input type="number" name="max_uses" class="form-control" placeholder="Kosongkan jika tak terbatas" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3" style="border: none;">
                        <button type="button" class="btn btn-secondary btn-sm px-3.5 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-bold" style="border-radius: 8px; background: #5c55e3; border: none; box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL DISCOUNT (WIDER & RESPONSIVE GRID) -->
    <div class="modal fade" id="detailDiscountModal" tabindex="-1" aria-labelledby="detailDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 14px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #5c55e3; padding: 16px 24px; border: none;">
                    <h5 class="modal-title fw-bold" id="detailDiscountModalLabel">Detail Voucher Diskon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- 1. READ VIEW (DEFAULT VIEW) -->
                <div id="readDiscountView">
                    <div class="modal-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold text-primary mb-0" id="read_code" style="font-size: 1.4rem;">MINDFITCODE</h3>
                            <span class="badge" id="read_status_badge" style="font-size: 0.72rem; padding: 5px 12px; border-radius: 30px;">Status</span>
                        </div>
                        <div class="row g-4 text-start">
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Tipe Voucher</small>
                                <span class="fw-bold text-dark" id="read_type" style="font-size: 0.9rem;">Persentase</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Nilai Potongan</small>
                                <span class="fw-bold text-success" id="read_value" style="font-size: 0.9rem;">15%</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Batas Maksimal Potongan</small>
                                <span class="fw-bold text-dark" id="read_max_limit" style="font-size: 0.9rem;">Tidak Terbatas</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Minimal Pembelian</small>
                                <span class="fw-bold text-dark" id="read_min_purchase" style="font-size: 0.9rem;">Tidak Ada</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Kuota Penggunaan</small>
                                <span class="fw-bold text-dark" id="read_uses_status" style="font-size: 0.9rem;">0 / Tidak Terbatas</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Tanggal Mulai</small>
                                <span class="fw-bold text-dark" id="read_start_date" style="font-size: 0.9rem;">Selamanya</span>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Tanggal Berakhir</small>
                                <span class="fw-bold text-dark" id="read_end_date" style="font-size: 0.9rem;">Selamanya</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3 d-flex justify-content-between" style="border: none;">
                        <div>
                            <!-- Delete Form -->
                            <form id="deleteDiscountForm" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-xs px-3 py-2 fw-semibold" style="border-radius: 8px;" onclick="return confirm('PENTING: Apakah Anda benar-benar yakin ingin menghapus voucher ini? Tindakan ini akan menghapus voucher secara permanen dan tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-sm px-3 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                            <button type="button" class="btn btn-primary btn-sm px-4 py-2 fw-bold" id="btnSwitchToEdit" style="border-radius: 8px; background: #5c55e3; border: none;">
                                <i class="fas fa-edit me-1"></i> Edit Data
                            </button>
                        </div>
                    </div>
                </div>
 
                <!-- 2. EDIT VIEW (HIDDEN BY DEFAULT) -->
                <form id="updateDiscountForm" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <!-- Row 1: Code and Status -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="edit_code" class="form-label">Kode Voucher <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="edit_code" class="form-control" required style="text-transform: uppercase;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_is_active" class="form-label">Status Voucher <span class="text-danger">*</span></label>
                                <select name="is_active" id="edit_is_active" class="form-select" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Type and Value -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="edit_type" class="form-label">Jenis Potongan <span class="text-danger">*</span></label>
                                <select name="type" id="edit_type" class="form-select" required>
                                    <option value="percent">Persentase (%)</option>
                                    <option value="nominal">Nominal (Rupiah)</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_value" class="form-label">Nilai Potongan <span class="text-danger">*</span></label>
                                <input type="number" name="value" id="edit_value" class="form-control" min="1" required>
                            </div>
                        </div>

                        <!-- Row 3: Max limit and Min purchase -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="edit_max_limit" class="form-label">Batas Potongan Maksimal (Rp)</label>
                                <input type="number" name="edit_max_limit" id="edit_max_limit" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_min_purchase" class="form-label">Minimal Pembelian (Rp)</label>
                                <input type="number" name="min_purchase" id="edit_min_purchase" class="form-control" min="0">
                            </div>
                        </div>

                        <!-- Row 4: Dates -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="edit_start_date" class="form-label">Tanggal Mulai Berlaku</label>
                                <input type="date" name="start_date" id="edit_start_date" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="edit_end_date" class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="end_date" id="edit_end_date" class="form-control">
                            </div>
                        </div>

                        <!-- Row 5: Max uses -->
                        <div class="row g-3">
                            <div class="col-md-6 form-group">
                                <label for="edit_max_uses" class="form-label">Kuota Penggunaan (Orang)</label>
                                <input type="number" name="max_uses" id="edit_max_uses" class="form-control" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3" style="border: none;">
                        <button type="button" class="btn btn-secondary btn-sm px-3.5 py-2 fw-semibold" id="btnSwitchToRead" style="border-radius: 8px;">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-bold" style="border-radius: 8px; background: #5c55e3; border: none;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentDiscountObj = null;

            // Fetch and open detail modal
            function viewDiscountDetail(id) {
                // Fetch coupon details via AJAX
                $.ajax({
                    url: `/admin/discounts/${id}`,
                    method: 'GET',
                    success: function(d) {
                        currentDiscountObj = d;
                        
                        // Set read-only view values
                        $('#read_code').text(d.code);
                        $('#read_type').text(d.type === 'percent' ? 'Persentase (%)' : 'Nominal (Rupiah)');
                        $('#read_value').text(d.type === 'percent' ? d.value + '%' : 'Rp ' + parseInt(d.value).toLocaleString('id-ID'));
                        
                        if (d.max_limit) {
                            $('#read_max_limit').text('Rp ' + parseInt(d.max_limit).toLocaleString('id-ID'));
                        } else {
                            $('#read_max_limit').text('Tidak Terbatas');
                        }

                        // Quota & Min Purchase view
                        $('#read_uses_status').text(d.used_count + ' / ' + (d.max_uses ? d.max_uses : 'Tidak Terbatas'));
                        $('#read_min_purchase').text(d.min_purchase ? 'Rp ' + parseInt(d.min_purchase).toLocaleString('id-ID') : 'Tidak Ada');

                        // Dates formatting
                        $('#read_start_date').text(d.start_date ? formatDateStr(d.start_date) : 'Selamanya');
                        $('#read_end_date').text(d.end_date ? formatDateStr(d.end_date) : 'Selamanya');

                        // Status badge formatting
                        if (d.is_active) {
                            $('#read_status_badge').text('Aktif').removeClass().addClass('badge bg-success');
                        } else {
                            $('#read_status_badge').text('Nonaktif').removeClass().addClass('badge bg-danger');
                        }

                        // Update Form action routes
                        $('#deleteDiscountForm').attr('action', `/admin/discounts/${id}`);
                        $('#updateDiscountForm').attr('action', `/admin/discounts/${id}`);

                        // Switch views back to Read Mode default
                        switchToReadMode();

                        // Open modal
                        var detailModal = new bootstrap.Modal(document.getElementById('detailDiscountModal'));
                        detailModal.show();
                    },
                    error: function() {
                        alert('Gagal mengambil data rincian diskon.');
                    }
                });
            }

            function formatDateStr(dateStr) {
                const d = new Date(dateStr);
                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();
                return `${day}/${month}/${year}`;
            }

            function formatDateYYYYMMDD(dateStr) {
                if (!dateStr) return '';
                const d = new Date(dateStr);
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // View mode switches
            function switchToEditMode() {
                if (!currentDiscountObj) return;

                const d = currentDiscountObj;
                // Pre-fill form fields
                $('#edit_code').val(d.code);
                $('#edit_type').val(d.type);
                $('#edit_value').val(d.value);
                $('#edit_max_limit').val(d.max_limit || '');
                $('#edit_max_uses').val(d.max_uses || '');
                $('#edit_min_purchase').val(d.min_purchase || '');
                $('#edit_start_date').val(formatDateYYYYMMDD(d.start_date));
                $('#edit_end_date').val(formatDateYYYYMMDD(d.end_date));
                $('#edit_is_active').val(d.is_active ? '1' : '0');

                // Toggle elements
                $('#readDiscountView').hide();
                $('#updateDiscountForm').show();
                $('#detailDiscountModalLabel').text('Edit Voucher Diskon');
            }

            function switchToReadMode() {
                $('#updateDiscountForm').hide();
                $('#readDiscountView').show();
                $('#detailDiscountModalLabel').text('Detail Voucher Diskon');
            }

            // Handlers
            $('#btnSwitchToEdit').on('click', switchToEditMode);
            $('#btnSwitchToRead').on('click', switchToReadMode);
        </script>
    @endpush
</x-app-layout>
