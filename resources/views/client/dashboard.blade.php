<x-app-layout>
    <x-slot name="header">Dashboard Klien</x-slot>

    {{-- ACTION BUTTON --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('client.payment.create') }}" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-plus-circle"></i> Daftar Paket Baru / Perpanjang Langganan
            </a>
        </div>
    </div>

    {{-- WHATSAPP DIRECTION FOR PENDING PAYMENT --}}
    @if($payments->first() && $payments->first()->status == 'pending')
        @php
            $latestPayment = $payments->first();
            $packageName = $latestPayment->package_data['package_name'] ?? '-';
            $cleanPackageName = str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $packageName);
            $totalPrice = $latestPayment->package_data['total_price'] ?? $latestPayment->package_data['package_price'] ?? 0;
            
            // Format WhatsApp Message template
            $messageText = "Halo Admin MindFit, saya baru saja melakukan pendaftaran paket baru dan mengunggah bukti pembayaran.\n\nBerikut rincian pendaftaran saya:\n- Nama: " . Auth::user()->name . "\n- Paket: " . $cleanPackageName . "\n- Total Tagihan: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\nMohon bantuannya untuk memproses verifikasi. Terima kasih!";
            $whatsappUrl = "https://wa.me/6285199615786?text=" . rawurlencode($messageText);
        @endphp
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-stats card-round p-3" style="border-left: 5px solid #25d366; background-color: rgba(37, 211, 102, 0.05); margin-bottom: 0;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap p-2">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <div class="icon-big text-center text-success me-3" style="font-size: 2.2rem;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-success">Pendaftaran Berhasil Dikirim!</h5>
                                <p class="text-muted mb-0 small">Silakan konfirmasi ke WhatsApp Admin agar status Premium Anda segera diaktifkan.</p>
                            </div>
                        </div>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success btn-round shadow-sm px-4">
                            <i class="fab fa-whatsapp me-2"></i> Hubungi Admin (WA)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- HISTORY TABLE --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat & Status Langganan</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Paket</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Periode Paket</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $p)
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td>
                                            <b>{{ $p->package_data['package_name'] ?? '-' }}</b><br>
                                            <small>{{ $p->package_data['package_duration'] ?? 0 }} Hari</small>
                                        </td>
                                        <td>Rp {{ number_format($p->package_data['total_price'] ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if($p->status == 'approved')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($p->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($p->status == 'revision')
                                                <span class="badge badge-warning">Revisi</span>
                                            @elseif($p->status == 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status == 'approved' && $p->subscription_end)
                                                {{ \Carbon\Carbon::parse($p->subscription_end)->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.payment.show', $p->id) }}" class="btn btn-primary btn-sm btn-round">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="mb-3 text-muted" style="font-size: 3rem; opacity: 0.6;">
                                                    <i class="fas fa-receipt"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-2">Belum Ada Riwayat Langganan</h5>
                                                <p class="text-muted small mb-4" style="max-width: 420px; margin: 0 auto; line-height: 1.6;">
                                                    Anda belum terdaftar di paket keanggotaan manapun. Yuk, mulai perjalanan pola makan sehat & kebugaran Anda bersama kami!
                                                </p>
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="{{ route('client.payment.create') }}" class="btn btn-primary btn-round px-4">
                                                        <i class="fas fa-plus-circle me-1"></i> Daftar Paket Baru
                                                    </a>
                                                    <a href="{{ route('client.ai.index') }}" class="btn btn-outline-primary btn-round px-4">
                                                        <i class="fas fa-brain me-1"></i> Rekomendasi Fitur AI
                                                    </a>
                                                </div>
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
</x-app-layout>