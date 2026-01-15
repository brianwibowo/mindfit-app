<x-app-layout>
    <x-slot name="header">Detail Langganan</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Detail Transaksi</div>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $payment->status == 'approved' ? 'success' : ($payment->status == 'pending' ? 'warning' : ($payment->status == 'revision' ? 'warning' : 'danger')) }}">
                                            {{ strtoupper($payment->status) }}
                                        </span>
                                        @if($payment->status == 'revision')
                                            <div class="alert alert-warning mt-2 p-2">
                                                <small class="fw-bold"><i class="fas fa-exclamation-circle"></i> Catatan
                                                    Admin:</small><br>
                                                {{ $payment->admin_note }}
                                                <div class="mt-2">
                                                    <a href="{{ route('client.payment.edit', $payment->id) }}"
                                                        class="btn btn-warning btn-xs btn-block">
                                                        <i class="fas fa-edit"></i> Edit / Perbaiki
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>{{ $payment->created_at->format('d M Y, H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <th>Paket</th>
                                    <td>{{ $payment->package_data['package_name'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>{{ $payment->package_data['package_duration'] ?? 0 }} Hari</td>
                                </tr>
                                <tr>
                                    <th>Harga Paket</th>
                                    <td>Rp
                                        {{ number_format($payment->package_data['package_price'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Add-on Meal Plan</th>
                                    <td>
                                        @if(!empty($payment->package_data['addon_meal_plan']))
                                            <span class="text-success">Ya (+ Rp 400.000)</span>
                                        @else
                                            <span class="text-muted">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h4>Total</h4>
                                    </th>
                                    <th>
                                        <h4>Rp
                                            {{ number_format($payment->package_data['total_price'] ?? 0, 0, ',', '.') }}
                                        </h4>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>Bukti Pembayaran</h5>
                            <img src="{{ asset('storage/' . $payment->proof_file) }}"
                                class="img-fluid rounded border mb-2" style="max-height: 300px;">
                            <br>
                            <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-search-plus"></i> Lihat Full Size
                            </a>
                        </div>
                    </div>

                    {{-- Revision Alert moved to table --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>