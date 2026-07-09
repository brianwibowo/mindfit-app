<x-app-layout>
    <x-slot name="header">Progress & Capaian Saya</x-slot>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h3 class="fw-bold text-dark mb-0">Riwayat & Log Progress Harian</h3>
                        <button type="button" class="btn btn-primary btn-round ms-md-auto mb-2" data-bs-toggle="modal" data-bs-target="#createProgressModal">
                            <i class="fa fa-plus-circle me-1"></i> Catat Progress Baru
                        </button>
                    </div>
                    <p class="text-muted text-xs mt-1 mb-3">Catat perkembangan berat badan, lingkar pinggang, foto perkembangan fisik, laporan latihan, dan pola makan Anda secara rutin.</p>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">UKURAN FISIK</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">FOTO FISIK</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">LOG / CATATAN</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; width: 30%;">FEEDBACK COACH</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            <strong class="text-dark" style="font-size: 0.9rem;">{{ $log->date->format('d M Y') }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                @if($log->weight)
                                                    <span class="small text-dark fw-bold"><i class="fas fa-weight-hanging text-muted me-1" style="width: 16px;"></i> {{ $log->weight }} kg</span>
                                                @endif
                                                @if($log->waist)
                                                    <span class="small text-dark"><i class="fas fa-ruler-horizontal text-muted me-1" style="width: 16px;"></i> {{ $log->waist }} cm</span>
                                                @endif
                                                @if($log->height)
                                                    <span class="small text-muted"><i class="fas fa-arrows-alt-v text-muted me-1" style="width: 16px;"></i> {{ $log->height }} cm</span>
                                                @endif
                                                @if(!$log->weight && !$log->waist && !$log->height)
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($log->photo)
                                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank" class="d-inline-block">
                                                    <img src="{{ asset('storage/' . $log->photo) }}" 
                                                         alt="Foto Progress" 
                                                         class="rounded border hover-shadow" 
                                                         style="width: 48px; height: 48px; object-fit: cover; border-color: #cbd5e0 !important; transition: all 0.2s;">
                                                </a>
                                            @else
                                                <span class="text-muted small"><i class="far fa-image text-muted" style="font-size: 1.2rem; opacity: 0.5;"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = 'bg-primary';
                                                $typeName = 'Workout';
                                                if ($log->type === 'body_check') {
                                                    $badgeClass = 'bg-info';
                                                    $typeName = 'Body Check';
                                                } elseif ($log->type === 'nutrition') {
                                                    $badgeClass = 'bg-success';
                                                    $typeName = 'Nutrisi';
                                                }
                                            @endphp
                                            <span class="badge badge-pill {{ $badgeClass }} text-white px-2 py-0.5 rounded-pill fw-bold mb-1" style="font-size: 9px;">
                                                {{ strtoupper($typeName) }}
                                            </span>
                                            <p class="small text-muted mb-0" style="line-height: 1.3;">{{ Str::limit($log->description, 50) ?: '-' }}</p>
                                        </td>
                                        <td>
                                            @if($log->coach_note)
                                                <div class="p-2 mb-0 rounded border-start border-3" style="background-color: #fef8eb; border-color: #ffc107 !important;">
                                                    <div class="fw-bold text-warning small mb-0.5"><i class="fas fa-comment-dots me-1"></i>{{ $log->coach->name ?? 'Coach' }}</div>
                                                    <p class="mb-0 small text-dark fst-italic">"{{ $log->coach_note }}"</p>
                                                </div>
                                            @else
                                                <span class="text-muted small fst-italic">Belum ada umpan balik</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('client.progress.show', $log->id) }}" 
                                               class="btn btn-sm btn-round btn-primary px-3 shadow-sm d-inline-flex align-items-center" 
                                               style="font-size: 0.78rem;">
                                                <i class="fa fa-eye me-2"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-chart-bar fa-3x text-muted mb-3" style="opacity: 0.4;"></i>
                                                <h5 class="fw-bold mb-1">Belum Ada Catatan Progress</h5>
                                                <p class="small mb-0">Mulailah mencatat berat badan dan aktivitas harian Anda untuk melacak perkembangan latihan!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: ADD NEW PROGRESS (Catat Progress Baru) -->
    <div class="modal fade text-dark" id="createProgressModal" tabindex="-1" aria-labelledby="createProgressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h4 class="modal-title fw-bold text-dark" id="createProgressModalLabel">
                        <i class="fas fa-chart-line text-primary me-2"></i> Catat Progress Baru
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('client.progress.store') }}" method="POST" enctype="multipart/form-data" id="create-progress-form">
                    @csrf
                    <div class="modal-body p-4">
                        {{-- Row 1: Date & Type side-by-side --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Tanggal Pencatatan <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Tipe Log / Laporan <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select form-control" required>
                                        <option value="body_check">Body Check (Berat/Foto)</option>
                                        <option value="workout">Laporan Workout</option>
                                        <option value="nutrition">Laporan Nutrisi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Metrics --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Berat Badan (Kg)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="weight" class="form-control" placeholder="Contoh: 65.5">
                                        <span class="input-group-text bg-light fw-bold small text-muted">kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Lingkar Pinggang (cm)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="waist" class="form-control" placeholder="Opsional">
                                        <span class="input-group-text bg-light fw-bold small text-muted">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Tinggi Badan (cm)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="height" class="form-control" placeholder="Opsional">
                                        <span class="input-group-text bg-light fw-bold small text-muted">cm</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Photo & Description --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Foto Kondisi Fisik <span class="text-muted small">(Opsional)</span></label>
                                    <input type="file" name="photo" class="form-control" accept="image/*,image/heic,image/heif,.heic,.heif">
                                    <small class="text-muted d-block mt-1">Format: JPG, PNG, HEIC, HEIF. Maksimal 2MB.</small>
                                    <div class="mt-2 text-center d-none" id="progress-photo-preview-container">
                                        <img id="progress-photo-preview" src="#" alt="Preview Foto" class="img-fluid rounded border shadow-sm" style="max-height: 120px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="fw-bold mb-1">Catatan Tambahan / Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Bagaimana latihan hari ini? Apakah menu makan tercukupi? Catat di sini."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-end gap-2" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                        <button type="button" class="btn btn-secondary btn-round px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-round px-4"><i class="fas fa-save me-1"></i> Simpan Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-render file upload preview in progress modal
            $('input[name="photo"]').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#progress-photo-preview').attr('src', e.target.result);
                        $('#progress-photo-preview-container').removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#progress-photo-preview-container').addClass('d-none');
                }
            });

            // Form spinner display on submit
            $('#create-progress-form').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            });
        });
    </script>
    @endpush
</x-app-layout>