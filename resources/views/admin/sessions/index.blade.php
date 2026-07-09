<x-app-layout>
    <x-slot name="header">Monitoring Sesi Latihan</x-slot>

    <!-- Custom styling for shimmer feedback, segmented control tabs, and card rows -->
    <style>
        /* Shimmer loading placeholder styling */
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

        /* Segmented Control tabs style */
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

        /* Select element styling tweaks */
        .form-select.quick-status-select:focus {
            box-shadow: none;
        }
    </style>

    <!-- Shimmer Skeleton Template -->
    <template id="table-skeleton-template">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">WAKTU</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">SESI</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PELATIH (COACH)</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">KLIEN</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">STATUS SESI</th>
                        <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td><div class="skeleton-shimmer" style="width: 100px; height: 16px; border-radius: 4px;"></div></td>
                        <td><div class="skeleton-shimmer" style="width: 80px; height: 16px; border-radius: 4px;"></div></td>
                        <td>
                            <div class="skeleton-shimmer" style="width: 150px; height: 16px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 60px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td>
                            <div class="skeleton-shimmer" style="width: 120px; height: 16px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 90px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td>
                            <div class="skeleton-shimmer" style="width: 120px; height: 16px; border-radius: 4px;"></div>
                            <div class="skeleton-shimmer mt-1" style="width: 110px; height: 10px; border-radius: 4px;"></div>
                        </td>
                        <td><div class="skeleton-shimmer" style="width: 110px; height: 28px; border-radius: 20px;"></div></td>
                        <td><div class="skeleton-shimmer mx-auto" style="width: 100px; height: 28px; border-radius: 20px;"></div></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </template>

    <!-- Main Table Card wrapped in row mb-5 to prevent footer overlap/cut-off -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Monitoring & Jadwal Sesi Pertemuan</h3>
                            <p class="text-muted text-xs mb-0">Jadwalkan sesi bimbingan nutrisi atau fitness secara langsung dengan klien.</p>
                        </div>
                        <!-- Modal Trigger Button -->
                        <button type="button" class="btn btn-primary btn-round ms-md-auto mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#createSessionModal">
                            <i class="fa fa-plus"></i> Buat Sesi Baru
                        </button>
                    </div>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    {{-- Tabs navigation (Segmented Control style) --}}
                    <div class="mb-4 overflow-auto" style="white-space: nowrap; -webkit-overflow-scrolling: touch; max-width: 100%;">
                        <ul class="nav nav-pills-segmented" id="time-tabs" style="flex-wrap: nowrap; margin-bottom: 0 !important;">
                            <li class="nav-item">
                                <a class="nav-link {{ $timeFilter == 'today' ? 'active' : '' }}" data-filter="today"
                                    href="{{ route('admin.sessions.index', ['time_filter' => 'today']) }}">
                                    <i class="fa fa-calendar-day me-1"></i> Sesi Hari Ini
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $timeFilter == 'upcoming' ? 'active' : '' }}" data-filter="upcoming"
                                    href="{{ route('admin.sessions.index', ['time_filter' => 'upcoming']) }}">
                                    <i class="fa fa-calendar-alt me-1"></i> Mendatang (Upcoming)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $timeFilter == 'history' ? 'active' : '' }}" data-filter="history"
                                    href="{{ route('admin.sessions.index', ['time_filter' => 'history']) }}">
                                    <i class="fa fa-history me-1"></i> Riwayat Selesai & Batal
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Dynamic table container --}}
                    <div id="sessions-table-container">
                        @include('admin.sessions.partials.table_body')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CREATE SESSION (wide 2-column layout to avoid scrolling) -->
    <div class="modal fade" id="createSessionModal" tabindex="-1" aria-labelledby="createSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createSessionModalLabel">Penjadwalan Sesi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sessions.store') }}" method="POST" id="create-session-form">
                    @csrf
                    <div class="modal-body py-3">
                        {{-- Row 1: Coach & Client side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Pilih Pelatih (Coach)</label>
                                    <select class="form-select form-control" name="coach_id" required>
                                        <option value="">-- Pilih Coach --</option>
                                        @foreach($coaches as $coach)
                                            <option value="{{ $coach->id }}" {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                                {{ $coach->name }} ({{ ucfirst($coach->role) }} - {{ ucfirst($coach->specialization) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Pilih Klien</label>
                                    <select class="form-select form-control" name="client_id" required>
                                        <option value="">-- Pilih Klien --</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }} ({{ $client->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Date & Time side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Tanggal</label>
                                    <input type="date" class="form-control" name="date" value="{{ old('date') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Waktu (Jam)</label>
                                    <input type="time" class="form-control" name="time" value="{{ old('time') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Title & Type side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Judul Pertemuan</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                        placeholder="Contoh: Bimbingan Evaluasi Gizi Minggu 1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Tipe Sesi</label>
                                    <select class="form-select form-control" name="type" required>
                                        <option value="online" {{ old('type') == 'online' ? 'selected' : '' }}>Online (Google Meet/Zoom)</option>
                                        <option value="offline" {{ old('type') == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 4: Notes full-width --}}
                        <div class="form-group mb-0">
                            <label class="fw-bold">Catatan / Link Meeting (Opsional)</label>
                            <textarea class="form-control" name="notes" rows="2"
                                placeholder="Masukkan link online meeting atau keterangan detail lokasi">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-round" id="create-submit-btn">Simpan Sesi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: EDIT SESSION (wide 2-column layout to avoid scrolling) -->
    <div class="modal fade" id="editSessionModal" tabindex="-1" aria-labelledby="editSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editSessionModalLabel">Ubah Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="edit-session-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        {{-- Row 1: Coach & Client side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Pilih Pelatih (Coach)</label>
                                    <select class="form-select form-control" name="coach_id" id="edit-coach-id" required>
                                        @foreach($coaches as $coach)
                                            <option value="{{ $coach->id }}">
                                                {{ $coach->name }} ({{ ucfirst($coach->role) }} - {{ ucfirst($coach->specialization) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Pilih Klien</label>
                                    <select class="form-select form-control" name="client_id" id="edit-client-id" required>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->name }} ({{ $client->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Date & Time side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Tanggal</label>
                                    <input type="date" class="form-control" name="date" id="edit-date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Waktu (Jam)</label>
                                    <input type="time" class="form-control" name="time" id="edit-time" required>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Title & Type side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Judul Pertemuan</label>
                                    <input type="text" class="form-control" name="title" id="edit-title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Tipe Sesi</label>
                                    <select class="form-select form-control" name="type" id="edit-type" required>
                                        <option value="online">Online (Google Meet/Zoom)</option>
                                        <option value="offline">Offline (Tatap Muka)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 4: Status & Notes side-by-side --}}
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Status Sesi</label>
                                    <select class="form-select form-control" name="status" id="edit-status" required>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Catatan / Link Meeting (Opsional)</label>
                                    <textarea class="form-control" name="notes" id="edit-notes" rows="1"
                                        placeholder="Link meeting atau keterangan lokasi"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-round" id="edit-submit-btn">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: SESSION DETAILS -->
    <div class="modal fade" id="detailSessionModal" tabindex="-1" aria-labelledby="detailSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="detailSessionModalLabel">Rincian Detail Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <table class="table table-striped table-bordered mb-0">
                        <tr>
                            <th style="width: 35%;">Judul Sesi</th>
                            <td><strong id="det-title"></strong></td>
                        </tr>
                        <tr>
                            <th>Tipe Sesi</th>
                            <td><span class="badge bg-light text-dark border px-2 py-1" id="det-type"></span></td>
                        </tr>
                        <tr>
                            <th>Pelatih (Coach)</th>
                            <td><span id="det-coach"></span> <br><small class="text-muted" id="det-coach-spec"></small></td>
                        </tr>
                        <tr>
                            <th>Klien</th>
                            <td id="det-client"></td>
                        </tr>
                        <tr>
                            <th>Jadwal Sesi</th>
                            <td>
                                <i class="fa fa-calendar me-1 text-muted"></i> <span id="det-date"></span><br>
                                <i class="fa fa-clock me-1 text-muted"></i> Jam <span id="det-time"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge" id="det-status"></span></td>
                        </tr>
                        <tr>
                            <th>Catatan Pertemuan</th>
                            <td>
                                <div class="bg-light p-2 rounded text-muted" id="det-notes" style="white-space: pre-wrap; font-size: 0.85rem; max-height: 120px; overflow-y: auto;">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between p-3 bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <div>
                        <!-- Delete Form for detail modal -->
                        <form id="delete-session-from-detail-form" method="POST" class="d-inline mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-round btn-sm" onclick="return confirm('PENTING: Apakah Anda benar-benar yakin ingin menghapus sesi bimbingan ini secara permanen?')">
                                <i class="fa fa-trash me-1"></i> Hapus Sesi
                            </button>
                        </form>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary btn-round btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-round btn-sm" id="btn-edit-from-detail">
                            <i class="fa fa-edit me-1"></i> Edit Jadwal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            let activeFilter = "{{ $timeFilter }}";

            // 1. Time filter Tab click
            $('#time-tabs .nav-link').on('click', function (e) {
                e.preventDefault();
                $('#time-tabs .nav-link').removeClass('active');
                $(this).addClass('active');

                activeFilter = $(this).data('filter');
                fetchSessions(1);
            });

            // 2. Pagination delegation click
            $(document).on('click', '#sessions-table-container .pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchSessions(page);
            });

            // 3. Quick Status AJAX Switcher
            $(document).on('change', '.quick-status-select', function () {
                let selectEl = $(this);
                let spinnerEl = selectEl.siblings('.status-spinner');
                let sessionId = selectEl.data('id');
                let newStatus = selectEl.val();

                // Disable input and display inline loading spinner
                selectEl.prop('disabled', true);
                spinnerEl.removeClass('d-none');

                $.ajax({
                    url: `/admin/sessions/${sessionId}/status`,
                    type: "PATCH",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: newStatus
                    },
                    success: function (res) {
                        selectEl.prop('disabled', false);
                        spinnerEl.addClass('d-none');

                        // Dynamically update drop-down color scheme based on selected status
                        if (res.status === 'scheduled') {
                            selectEl.css({'background-color': '#e8f0fe', 'color': '#1a73e8'});
                        } else if (res.status === 'completed') {
                            selectEl.css({'background-color': '#e6f4ea', 'color': '#137333'});
                        } else {
                            selectEl.css({'background-color': '#fce8e6', 'color': '#c5221f'});
                        }

                        // Play SweetAlert success
                        swal({
                            title: "Berhasil!",
                            text: res.message,
                            icon: "success",
                            timer: 2000,
                            buttons: false
                        });
                    },
                    error: function (xhr) {
                        selectEl.prop('disabled', false);
                        spinnerEl.addClass('d-none');
                        console.error(xhr);

                        swal({
                            title: "Error!",
                            text: "Gagal memperbarui status sesi. Silakan coba lagi.",
                            icon: "error"
                        });
                    }
                });
            });

            // 4. Open Edit Session Modal and prefill form properties
            $(document).on('click', '.btn-edit-session', function () {
                let btn = $(this);
                let id = btn.data('id');
                
                // Construct action path
                $('#edit-session-form').attr('action', `/admin/sessions/${id}`);
                
                // Fill fields
                $('#edit-coach-id').val(btn.data('coach'));
                $('#edit-client-id').val(btn.data('client'));
                $('#edit-date').val(btn.data('date'));
                $('#edit-time').val(btn.data('time'));
                $('#edit-title').val(btn.data('title'));
                $('#edit-type').val(btn.data('type'));
                $('#edit-status').val(btn.data('status'));
                $('#edit-notes').val(btn.data('notes'));

                let editModal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                editModal.show();
            });

            // 5. Open Details Modal via AJAX
            $(document).on('click', '.btn-detail-session', function () {
                let sessionId = $(this).data('id');

                $.ajax({
                    url: `/admin/sessions/${sessionId}`,
                    type: "GET",
                    success: function (res) {
                        if (res.success) {
                            let d = res.data;
                            $('#det-title').text(d.title);
                            $('#det-type').text(d.type);
                            $('#det-coach').text(d.coach_name);
                            $('#det-coach-spec').text(`${d.coach_role} - ${d.coach_spec}`);
                            $('#det-client').text(d.client_name);
                            $('#det-date').text(d.date_formatted);
                            $('#det-time').text(d.time_formatted);
                            $('#det-notes').text(d.notes);

                            // Setup Delete form action in detail modal
                            $('#delete-session-from-detail-form').attr('action', `/admin/sessions/${d.id}`);

                            // Attach data properties to edit button in detail modal
                            let editBtn = $('#btn-edit-from-detail');
                            editBtn.data('id', d.id);
                            editBtn.data('coach', d.coach_id);
                            editBtn.data('client', d.client_id);
                            editBtn.data('date', d.date_raw);
                            editBtn.data('time', d.time_raw);
                            editBtn.data('title', d.title);
                            editBtn.data('type', d.type_raw);
                            editBtn.data('status', d.status_raw);
                            editBtn.data('notes', d.notes);

                            // Badge styling logic
                            let statusBadge = $('#det-status');
                            statusBadge.text(d.status);
                            statusBadge.removeClass('bg-primary bg-success bg-danger');
                            if (d.status_raw === 'scheduled') {
                                statusBadge.addClass('bg-primary text-white');
                            } else if (d.status_raw === 'completed') {
                                statusBadge.addClass('bg-success text-white');
                            } else {
                                statusBadge.addClass('bg-danger text-white');
                            }

                            let detailModal = new bootstrap.Modal(document.getElementById('detailSessionModal'));
                            detailModal.show();
                        }
                    },
                    error: function () {
                        swal({
                            title: "Error!",
                            text: "Gagal memuat rincian detail sesi.",
                            icon: "error"
                        });
                    }
                });
            });

            // 5b. Edit from Detail Modal handler
            $(document).on('click', '#btn-edit-from-detail', function () {
                // Dismiss detail modal
                $('#detailSessionModal').modal('hide');
                
                let btn = $(this);
                let id = btn.data('id');
                
                // Populate edit inputs
                $('#edit-session-form').attr('action', `/admin/sessions/${id}`);
                $('#edit-coach-id').val(btn.data('coach'));
                $('#edit-client-id').val(btn.data('client'));
                $('#edit-date').val(btn.data('date'));
                $('#edit-time').val(btn.data('time'));
                $('#edit-title').val(btn.data('title'));
                $('#edit-type').val(btn.data('type'));
                $('#edit-status').val(btn.data('status'));
                $('#edit-notes').val(btn.data('notes'));

                // Open edit modal with transition delay
                setTimeout(function() {
                    let editModal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                    editModal.show();
                }, 350);
            });

            // 6. Form double click submit protection
            $('#create-session-form').on('submit', function () {
                $('#create-submit-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            });
            $('#edit-session-form').on('submit', function () {
                $('#edit-submit-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            });

            // Fetch sessions ajax function
            function fetchSessions(page) {
                // Show skeleton rows
                let skeletonHtml = $('#table-skeleton-template').html();
                $('#sessions-table-container').html(skeletonHtml);

                // Update location URL
                let newUrl = window.location.pathname + '?time_filter=' + activeFilter;
                if (page > 1) {
                    newUrl += '&page=' + page;
                }
                window.history.pushState({ path: newUrl }, '', newUrl);

                $.ajax({
                    url: "{{ route('admin.sessions.index') }}",
                    type: "GET",
                    data: {
                        time_filter: activeFilter,
                        page: page
                    },
                    success: function (html) {
                        $('#sessions-table-container').html(html);
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        $('#sessions-table-container').html(`
                            <div class="alert alert-danger text-center my-3 py-3">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                                Gagal memuat jadwal sesi. Silakan coba lagi.
                            </div>
                        `);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>