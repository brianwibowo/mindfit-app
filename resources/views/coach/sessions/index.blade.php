<x-app-layout>
    <x-slot name="header">Manajemen Sesi Coaching</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Daftar Sesi Bimbingan</h4>
                        <small class="text-muted">Kelola jadwal konsultasi dan sesi bimbingan nutrisi atau fitness dengan klien Anda.</small>
                    </div>
                    <button type="button" class="btn btn-primary btn-round btn-sm" data-bs-toggle="modal" data-bs-target="#createSessionModal">
                        <i class="fas fa-plus me-1.5"></i> Jadwalkan Sesi
                    </button>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TANGGAL & WAKTU</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">KLIEN</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">JUDUL SESI</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TIPE</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">STATUS</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">CATATAN</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px; text-align: center; width: 120px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-dark fw-bold" style="font-size: 0.88rem;">
                                                <i class="far fa-calendar-alt text-muted me-1.5" style="font-size: 0.85rem;"></i>
                                                {{ $session->date->translatedFormat('d M Y') }}
                                            </span><br>
                                            <span class="text-secondary fw-semibold" style="font-size: 0.82rem;">
                                                <i class="far fa-clock text-muted me-1.5" style="font-size: 0.85rem;"></i>
                                                {{ $session->date->format('H:i') }} WIB
                                            </span>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $session->client->name }}</span><br>
                                            <small class="text-muted" style="font-size: 0.72rem; font-weight: 500;">
                                                {{ $session->client->email }}
                                            </small>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $session->title }}</span>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($session->type == 'online')
                                                <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(92, 85, 227, 0.08);">Online</span>
                                            @else
                                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(46, 204, 113, 0.08);">Offline</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($session->date->isPast())
                                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(46, 204, 113, 0.08);">Selesai</span>
                                            @else
                                                <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(92, 85, 227, 0.08);">Terjadwal</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-muted small" style="font-size: 0.78rem;">{{ Str::limit($session->notes, 25) ?: '-' }}</span>
                                        </td>
                                        <td style="padding: 12px 8px;" class="text-center">
                                            <button type="button" 
                                                    class="btn btn-xs fw-semibold px-3 py-1.5 btn-detail-session" 
                                                    data-id="{{ $session->id }}"
                                                    style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;"
                                                    onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" 
                                                    onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                                Lihat
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">Belum ada sesi yang dijadwalkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CREATE SESSION -->
    <div class="modal fade" id="createSessionModal" tabindex="-1" aria-labelledby="createSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createSessionModalLabel">Penjadwalan Sesi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('coach.sessions.store') }}" method="POST" id="create-session-form">
                    @csrf
                    <div class="modal-body py-3">
                        {{-- Row 1: Client select dropdown --}}
                        <div class="form-group mb-3 text-start">
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

                        {{-- Row 2: Date & Time --}}
                        <div class="row g-3 mb-3 text-start">
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

                        {{-- Row 3: Title & Type --}}
                        <div class="row g-3 mb-3 text-start">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold">Judul Pertemuan</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                        placeholder="Contoh: Sesi Latihan Upper Body" required>
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

                        {{-- Row 4: Notes --}}
                        <div class="form-group mb-0 text-start">
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

    <!-- MODAL: EDIT SESSION -->
    <div class="modal fade" id="editSessionModal" tabindex="-1" aria-labelledby="editSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editSessionModalLabel">Ubah Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="edit-session-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        {{-- Row 1: Client name (read-only for security) --}}
                        <div class="form-group mb-3 text-start">
                            <label class="fw-bold">Klien Bimbingan</label>
                            <input type="text" class="form-control bg-light" id="edit-client-name" readonly disabled>
                        </div>

                        {{-- Row 2: Date & Time --}}
                        <div class="row g-3 mb-3 text-start">
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

                        {{-- Row 3: Title & Type --}}
                        <div class="row g-3 mb-3 text-start">
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

                        {{-- Row 4: Notes --}}
                        <div class="form-group mb-0 text-start">
                            <label class="fw-bold">Catatan / Link Meeting (Opsional)</label>
                            <textarea class="form-control" name="notes" id="edit-notes" rows="2"
                                placeholder="Link meeting atau keterangan lokasi"></textarea>
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
            <div class="modal-content" style="border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="detailSessionModalLabel">Rincian Detail Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <table class="table table-striped table-bordered mb-0" style="border-radius: 8px; overflow: hidden;">
                        <tr>
                            <th style="width: 35%; text-align: left;">Judul Sesi</th>
                            <td id="det-title" style="text-align: left; font-weight: bold;"></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Tipe Sesi</th>
                            <td style="text-align: left;"><span class="badge bg-light text-dark border px-2 py-1" id="det-type"></span></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Klien</th>
                            <td id="det-client" style="text-align: left;"></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Jadwal Sesi</th>
                            <td style="text-align: left;">
                                <i class="fa fa-calendar me-1 text-muted"></i> <span id="det-date"></span><br>
                                <i class="fa fa-clock me-1 text-muted"></i> Jam <span id="det-time"></span>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Status</th>
                            <td><span class="badge" id="det-status"></span></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Catatan</th>
                            <td style="text-align: left;">
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
            // 1. Open Details Modal via AJAX
            $(document).on('click', '.btn-detail-session', function () {
                let sessionId = $(this).data('id');

                $.ajax({
                    url: `/coach/sessions/${sessionId}`,
                    type: "GET",
                    success: function (res) {
                        if (res.success) {
                            let d = res.data;
                            $('#det-title').text(d.title);
                            $('#det-type').text(d.type);
                            $('#det-client').text(d.client_name);
                            $('#det-date').text(d.date_formatted);
                            $('#det-time').text(d.time_formatted);
                            $('#det-notes').text(d.notes);

                            // Setup Delete form action in detail modal
                            $('#delete-session-from-detail-form').attr('action', `/coach/sessions/${d.id}`);

                            // Attach data properties to edit button in detail modal
                            let editBtn = $('#btn-edit-from-detail');
                            editBtn.data('id', d.id);
                            editBtn.data('client-name', d.client_name);
                            editBtn.data('date', d.date_raw);
                            editBtn.data('time', d.time_raw);
                            editBtn.data('title', d.title);
                            editBtn.data('type', d.type_raw);
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

            // 2. Edit from Detail Modal handler
            $(document).on('click', '#btn-edit-from-detail', function () {
                // Dismiss detail modal
                $('#detailSessionModal').modal('hide');
                
                let btn = $(this);
                let id = btn.data('id');
                
                // Populate edit inputs
                $('#edit-session-form').attr('action', `/coach/sessions/${id}`);
                $('#edit-client-name').val(btn.data('client-name'));
                $('#edit-date').val(btn.data('date'));
                $('#edit-time').val(btn.data('time'));
                $('#edit-title').val(btn.data('title'));
                $('#edit-type').val(btn.data('type'));
                $('#edit-notes').val(btn.data('notes'));

                // Open edit modal with transition delay
                setTimeout(function() {
                    let editModal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                    editModal.show();
                }, 350);
            });

            // 3. Form double click submit protection
            $('#create-session-form').on('submit', function () {
                $('#create-submit-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            });
            $('#edit-session-form').on('submit', function () {
                $('#edit-submit-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            });

            // 4. Auto-open Create Session Modal from query parameters (dashboard shortcut)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('create') === 'true') {
                const clientId = urlParams.get('client_id');
                if (clientId) {
                    $('#create-session-form select[name="client_id"]').val(clientId).change();
                }
                setTimeout(function() {
                    let createModal = new bootstrap.Modal(document.getElementById('createSessionModal'));
                    createModal.show();
                }, 300);
            }
        });
    </script>
    @endpush
</x-app-layout>