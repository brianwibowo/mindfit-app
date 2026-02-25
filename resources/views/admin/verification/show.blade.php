<x-app-layout>
    <x-slot name="header">Verifikasi Pembayaran</x-slot>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Pendaftaran</div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Nama Klien</th>
                            <td>{{ $payment->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $payment->user->email }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp</th>
                            <td>
                                @if($payment->user->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $payment->user->phone) }}"
                                        target="_blank" class="btn btn-sm btn-success">
                                        <i class="fab fa-whatsapp"></i> {{ $payment->user->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">Belum Diisi</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $payment->user->address ?? 'Belum Diisi' }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <th>Paket Dipilih</th>
                            <td>{{ $payment->package_data['package_name'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $payment->package_data['package_duration'] ?? 0 }} Hari</td>
                        </tr>
                        <tr>
                            <th>Paket Berakhir</th>
                            <td>
                                @if($payment->user->is_premium && $payment->user->premium_until)
                                    <span
                                        class="badge badge-info">{{ \Carbon\Carbon::parse($payment->user->premium_until)->format('d M Y') }}</span>
                                @else
                                    <span class="text-muted">Belum Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Add-on Meal Plan</th>
                            <td>
                                @if(!empty($payment->package_data['addon_meal_plan']))
                                    <span class="badge badge-success">Ya (+ Rp 400.000)</span>
                                @else
                                    <span class="badge badge-secondary">Tidak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h4>Total Tagihan</h4>
                            </th>
                            <th>
                                <h4>Rp {{ number_format($payment->package_data['total_price'] ?? 0, 0, ',', '.') }}</h4>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Bukti & Keputusan</div>
                </div>
                <div class="card-body">
                    {{-- Proof Image --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $payment->proof_file) }}" alt="Bukti Bayar"
                            class="img-fluid rounded border" style="max-height: 350px; cursor: pointer;"
                            onclick="window.open(this.src)">
                        <p class="text-muted mt-2"><small><i class="fas fa-search-plus"></i> Klik gambar untuk
                                memperbesar</small></p>
                    </div>

                    <div
                        class="alert alert-{{ $payment->status == 'approved' ? 'success' : ($payment->status == 'pending' ? 'warning' : ($payment->status == 'rejected' ? 'danger' : 'info')) }}">
                        Status Saat Ini: <b>{{ strtoupper($payment->status) }}</b>
                    </div>

                    {{-- Action Form (Only for pending/revision) --}}
                    @if($payment->status != 'approved' && $payment->status != 'rejected')
                        <hr>
                        <form action="{{ route('admin.verification.update', $payment->id) }}" method="POST">
                            @csrf

                            {{-- 1. DECISION DROPDOWN --}}
                            <div class="form-group">
                                <label for="actionSelect" class="fw-bold fs-5">Keputusan Admin <span
                                        class="text-danger">*</span></label>
                                <select name="action" id="actionSelect" class="form-select form-control" required>
                                    <option value="">-- Pilih Keputusan --</option>
                                    <option value="approved">✅ Setujui Pendaftaran (Aktifkan Member)</option>
                                    <option value="revision">⚠️ Minta Revisi (Kirim Catatan ke Klien)</option>
                                    <option value="rejected">❌ Tolak Pendaftaran (Permanen)</option>
                                </select>
                            </div>

                            {{-- 2. REVISION NOTE (Conditional) --}}
                            <div class="form-group d-none" id="revisionNoteGroup">
                                <label class="fw-bold">Catatan Revisi <span class="text-danger">*</span></label>
                                <textarea name="admin_note" id="adminNote" class="form-control" rows="3"
                                    placeholder="Jelaskan apa yang salah. Contoh: Bukti transfer tidak terbaca / Nominal kurang."></textarea>
                                <small class="text-muted">Catatan ini akan dikirimkan ke Klien.</small>
                            </div>

                            {{-- 3. CHECKLIST --}}
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                                <label class="form-check-label" for="confirmCheck">
                                    Saya sudah meninjau bukti pembayaran dan data calon member dengan teliti.
                                </label>
                            </div>

                            {{-- 4. SUBMIT --}}
                            <div class="form-action mt-4">
                                <button type="submit" class="btn btn-primary w-100 fw-bold">
                                    <i class="fas fa-save"></i> SIMPAN KEPUTUSAN
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            {{-- COACH ASSIGNMENT (Already Approved) --}}
            @if($payment->status == 'approved')
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="card-title">Tim Pelatih (Coaching Team)</div>
                    </div>
                    <div class="card-body">
                        @if($payment->user->coaches->count() > 0)
                            <table class="table table-sm">
                                @foreach($payment->user->coaches as $coach)
                                    <tr>
                                        <td>
                                            <b>{{ $coach->name }}</b>
                                            <div class="text-muted">{{ ucfirst($coach->pivot->type) }} Coach</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-muted text-center">Belum ada Coach yang di-assign.</p>
                        @endif

                        <hr>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#assignCoachModal">
                            <i class="fas fa-user-plus"></i> Assign Coach / Nutritionist
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL ASSIGN COACH --}}
    @if($payment->status == 'approved')
        <div class="modal fade" id="assignCoachModal" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('admin.coaches.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $payment->user_id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Coach</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Pilih Coach</label>
                                <select name="coach_id" class="form-control" required>
                                    <option value="">-- Pilih Coach --</option>
                                    @foreach($coaches as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }} ({{ ucfirst($c->specialization) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sebagai</label>
                                <select name="type" class="form-control" required>
                                    <option value="fitness">Fitness Coach</option>
                                    <option value="nutritionist">Nutritionist</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Assign Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#actionSelect').on('change', function () {
                    var val = $(this).val();
                    if (val === 'revision') {
                        $('#revisionNoteGroup').removeClass('d-none');
                        $('#adminNote').prop('required', true);
                    } else {
                        $('#revisionNoteGroup').addClass('d-none');
                        $('#adminNote').prop('required', false);
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>