<x-app-layout>
    <x-slot name="header">Verifikasi Pembayaran</x-slot>

    <div class="row">
        <div class="col-md-6">
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
                            <td>{{ $payment->user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $payment->user->address ?? '-' }}</td>
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
                            <th>Harga Paket</th>
                            <td>Rp {{ number_format($payment->package_data['package_price'] ?? 0, 0, ',', '.') }}</td>
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

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Bukti Pembayaran</div>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $payment->proof_file) }}" alt="Bukti Bayar"
                        class="img-fluid rounded mb-3" style="max-height: 400px; cursor: pointer;"
                        onclick="window.open(this.src)">
                    <p class="text-muted"><small>Klik gambar untuk memperbesar</small></p>

                    <div
                        class="alert alert-{{ $payment->status == 'approved' ? 'success' : ($payment->status == 'pending' ? 'warning' : ($payment->status == 'rejected' ? 'danger' : 'info')) }}">
                        Status Saat Ini: <b>{{ strtoupper($payment->status) }}</b>
                    </div>

                    {{-- Action Buttons (Only for pending/revision) --}}
                    @if($payment->status != 'approved' && $payment->status != 'rejected')
                        <hr>
                        <h4>Keputusan Admin:</h4>
                        <div class="d-flex gap-2 justify-content-center">
                            {{-- APPROVE --}}
                            <form action="{{ route('admin.verification.update', $payment->id) }}" method="POST"
                                onsubmit="return confirm('Yakin setujui? Klien akan langsung aktif.')">
                                @csrf @request('action', 'approved')
                                <input type="hidden" name="action" value="approved">
                                <button class="btn btn-success">
                                    <i class="fas fa-check"></i> SETUJUI (Active)
                                </button>
                            </form>

                            {{-- REVISE --}}
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviseModal">
                                <i class="fas fa-edit"></i> MINTA REVISI
                            </button>

                            {{-- REJECT --}}
                            <form action="{{ route('admin.verification.update', $payment->id) }}" method="POST"
                                onsubmit="return confirm('Yakin TOLAK pendaftaran ini? Aksi ini tidak bisa dibatalkan.')">
                                @csrf
                                <input type="hidden" name="action" value="rejected">
                                <button class="btn btn-danger">
                                    <i class="fas fa-times"></i> TOLAK (Failed)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- COACH ASSIGNMENT (Only for Approved) --}}
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
                                        {{-- Optional: Add remove button later --}}
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

    {{-- MODAL REVISI --}}
    <div class="modal fade" id="reviseModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.verification.update', $payment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="revision">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Catatan Revisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Apa yang perlu diperbaiki oleh Klien?</label>
                            <textarea name="admin_note" class="form-control" rows="4" required
                                placeholder="Contoh: Bukti transfer buram, mohon upload ulang."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Kirim Permintaan Revisi</button>
                    </div>
                </div>
            </form>
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

</x-app-layout>