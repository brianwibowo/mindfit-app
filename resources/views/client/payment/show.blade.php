<x-app-layout>
    <x-slot name="header">Detail Langganan</x-slot>

    @php
        $pt = isset($payment->package_data['pt_id']) ? \App\Models\User::find($payment->package_data['pt_id']) : null;
        $nutri = isset($payment->package_data['nutritionist_id']) ? \App\Models\User::find($payment->package_data['nutritionist_id']) : null;
        
        $status = $payment->status;
        $statusClass = 'secondary';
        $statusLabel = 'Menunggu';
        if ($status == 'approved') {
            $statusClass = 'success';
            $statusLabel = 'Disetujui';
        } elseif ($status == 'revision') {
            $statusClass = 'warning';
            $statusLabel = 'Revisi';
        } elseif ($status == 'declined') {
            $statusClass = 'danger';
            $statusLabel = 'Ditolak';
        }
    @endphp

    <div class="row text-dark">
        <!-- Main Container: Full Width col-12 -->
        <div class="col-12">
            <!-- Back Button and Header Actions -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Detail Transaksi & Layanan</h4>
                <a href="{{ route('client.dashboard') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <!-- 1. Transaction Status Timeline -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body py-4 bg-light rounded">
                    <div class="row align-items-center justify-content-center text-center">
                        <!-- Step 1 -->
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-2" style="width: 45px; height: 45px;">
                                <i class="fas fa-check"></i>
                            </div>
                            <h6 class="fw-bold text-success mb-1">Pendaftaran Dikirim</h6>
                            <small class="text-muted">{{ $payment->created_at->format('d M Y, H:i') }} WIB</small>
                        </div>
                        
                        <!-- Connector 1 -->
                        <div class="col-md-1 d-none d-md-block">
                            <hr class="border-top border-3 border-success mb-4" style="margin-top: -10px;">
                        </div>

                        <!-- Step 2 -->
                        <div class="col-md-3 mb-3 mb-md-0">
                            @if($status == 'approved')
                                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-2" style="width: 45px; height: 45px;">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <h6 class="fw-bold text-success mb-1">Diverifikasi Admin</h6>
                                <small class="text-muted">Proses Selesai</small>
                            @elseif($status == 'revision')
                                <div class="d-inline-flex align-items-center justify-content-center bg-warning text-white rounded-circle mb-2 animate__animated animate__pulse animate__infinite" style="width: 45px; height: 45px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h6 class="fw-bold text-warning mb-1">Butuh Revisi</h6>
                                <small class="text-muted">Tindakan Diperlukan</small>
                            @elseif($status == 'declined')
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-2" style="width: 45px; height: 45px;">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h6 class="fw-bold text-danger mb-1">Ditolak</h6>
                                <small class="text-muted">Data Tidak Valid</small>
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2 animate__animated animate__pulse animate__infinite" style="width: 45px; height: 45px;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                                <h6 class="fw-bold text-primary mb-1">Proses Verifikasi</h6>
                                <small class="text-muted">Antrean Peninjauan</small>
                            @endif
                        </div>

                        <!-- Connector 2 -->
                        <div class="col-md-1 d-none d-md-block">
                            @if($status == 'approved')
                                <hr class="border-top border-3 border-success mb-4" style="margin-top: -10px;">
                            @else
                                <hr class="border-top border-3 border-light mb-4" style="margin-top: -10px;">
                            @endif
                        </div>

                        <!-- Step 3 -->
                        <div class="col-md-3">
                            @if($status == 'approved')
                                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-2" style="width: 45px; height: 45px;">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <h6 class="fw-bold text-success mb-1">Layanan Aktif</h6>
                                <small class="text-muted">Mulai Latihan</small>
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle mb-2" style="width: 45px; height: 45px; opacity: 0.5;">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <h6 class="fw-bold text-muted mb-1">Layanan Aktif</h6>
                                <small class="text-muted">Menunggu Langkah 2</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Main content Layout Grid -->
            <div class="row">
                <!-- Left Side: Subscription & Invoice Receipt details -->
                <div class="col-lg-8">
                    <!-- Revision Message Widget (if applicable) -->
                    @if($status == 'revision')
                        <div class="alert alert-warning border-0 shadow-sm p-4 mb-4 d-flex align-items-start rounded">
                            <i class="fas fa-exclamation-circle fa-2x text-warning me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold text-warning mb-1">Pemberitahuan Revisi Pembayaran</h5>
                                <p class="mb-3 text-dark">Laporan pembayaran Anda membutuhkan perbaikan dengan catatan admin sebagai berikut:</p>
                                <div class="bg-white p-3 border rounded text-dark font-monospace small mb-3">
                                    "{{ $payment->admin_note }}"
                                </div>
                                <a href="{{ route('client.payment.edit', $payment->id) }}" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold">
                                    <i class="fas fa-edit me-1"></i> Edit & Perbaiki Pendaftaran Sekarang
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Layanan & Coach Card -->
                    <div class="card shadow-sm border-0 mb-4 text-dark">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-dumbbell text-primary me-2"></i> Rincian Program Layanan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Package Info -->
                                <div class="col-md-6 border-end pr-md-4">
                                    <h6 class="text-muted small fw-bold mb-2">PAKET YANG DIPILIH:</h6>
                                    <h3 class="fw-bold text-primary mb-1">{{ $payment->package_data['package_name'] ?? '-' }}</h3>
                                    <div class="mb-3">
                                        <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-bold">
                                            <i class="fas fa-calendar-alt me-1"></i> Durasi: {{ $payment->package_data['package_duration'] ?? 0 }} Hari
                                        </span>
                                    </div>
                                    
                                    <hr class="my-3">

                                    <div class="row text-dark">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Tanggal Daftar:</small>
                                            <strong style="font-size: 0.9rem;">{{ $payment->created_at->format('d M Y') }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Status Langganan:</small>
                                            <span class="badge bg-{{ $statusClass }} text-white rounded-pill px-2 py-0 fw-bold small">
                                                {{ strtoupper($statusLabel) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coach Info -->
                                <div class="col-md-6 pl-md-4">
                                    <h6 class="text-muted small fw-bold mb-3">STAFF PENDAMPING (COACH):</h6>
                                    
                                    <!-- Personal Trainer Assignment -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light-blue rounded-circle p-2 d-flex align-items-center justify-content-center text-primary" style="width: 44px; height: 44px;">
                                            <i class="fas fa-user-shield fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted d-block">Personal Trainer (PT):</small>
                                            <strong class="text-dark" style="font-size: 0.95rem;">{{ $pt ? $pt->name : 'Tidak Memilih' }}</strong>
                                        </div>
                                    </div>

                                    <!-- Nutritionist Assignment -->
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-blue rounded-circle p-2 d-flex align-items-center justify-content-center text-success" style="width: 44px; height: 44px;">
                                            <i class="fas fa-apple-alt fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted d-block">Nutritionist:</small>
                                            <strong class="text-dark" style="font-size: 0.95rem;">{{ $nutri ? $nutri->name : 'Tidak Memilih' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Summary Invoice Card -->
                    <div class="card shadow-sm border-0 mb-4 text-dark">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-receipt text-primary me-2"></i> Rincian Tagihan & Pembayaran</h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Invoice Receipt Table -->
                            <div class="table-responsive">
                                <table class="table align-middle text-dark">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th>DESKRIPSI ITEM</th>
                                            <th class="text-end">NOMINAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong class="text-dark">{{ $payment->package_data['package_name'] ?? '-' }}</strong>
                                                <small class="text-muted d-block">Layanan utama subscription selama {{ $payment->package_data['package_duration'] ?? 0 }} hari</small>
                                            </td>
                                            <td class="text-end fw-bold">
                                                Rp {{ number_format($payment->package_data['package_price'] ?? 0, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Addon Meal Plan row (if applicable) -->
                                        @if(!empty($payment->package_data['addon_meal_plan']))
                                            <tr>
                                                <td>
                                                    <strong class="text-dark">Add-on: Catering Meal Plan</strong>
                                                    <small class="text-success d-block">Layanan tambahan katering nutrisi harian</small>
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    + Rp 400.000
                                                </td>
                                            </tr>
                                        @endif

                                        <!-- Discount row (if applicable) -->
                                        @if(!empty($payment->package_data['discount_amount']) && $payment->package_data['discount_amount'] > 0)
                                            <tr>
                                                <td>
                                                    <strong class="text-danger">Potongan Diskon (Kode: {{ $payment->package_data['discount_code'] ?? '-' }})</strong>
                                                    <small class="text-muted d-block">Hemat sebesar {{ $payment->package_data['discount_percent'] ?? 0 }}% dari harga paket</small>
                                                </td>
                                                <td class="text-end fw-bold text-danger">
                                                    - Rp {{ number_format($payment->package_data['discount_amount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                        
                                        <!-- Grand Total row -->
                                        <tr class="table-light border-top border-2">
                                            <td>
                                                <h5 class="fw-bold mb-0 text-dark">Total Tagihan (Grand Total)</h5>
                                                <small class="text-muted">Nominal transfer wajib sesuai</small>
                                            </td>
                                            <td class="text-end">
                                                <h4 class="fw-bold text-primary mb-0">
                                                    Rp {{ number_format($payment->package_data['total_price'] ?? 0, 0, ',', '.') }}
                                                </h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- WhatsApp Confirmation Helper for Pending status -->
                            @if($status == 'pending')
                                @php
                                    $packageName = $payment->package_data['package_name'] ?? '-';
                                    $cleanPackageName = str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $packageName);
                                    $totalPrice = $payment->package_data['total_price'] ?? $payment->package_data['package_price'] ?? 0;
                                    
                                    $messageText = "Halo Admin MindFit, saya baru saja melakukan pendaftaran paket baru dan mengunggah bukti pembayaran.\n\nBerikut rincian pendaftaran saya:\n- Nama: " . Auth::user()->name . "\n- Paket: " . $cleanPackageName . "\n- Total Tagihan: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\nMohon bantuannya untuk memproses verifikasi. Terima kasih!";
                                    $whatsappUrl = "https://wa.me/6285199615786?text=" . rawurlencode($messageText);
                                @endphp
                                <div class="alert alert-info border-0 shadow-sm p-3 mt-3 d-flex align-items-center justify-content-between rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-whatsapp fa-2x text-success me-3"></i>
                                        <div class="small text-dark">
                                            <strong>Ingin proses verifikasi lebih cepat?</strong><br>
                                            Kirim konfirmasi manual langsung ke WhatsApp Admin MindFit.
                                        </div>
                                    </div>
                                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-4 fw-bold text-white">
                                        Hubungi Admin <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Side: Payment Proof Wrapper -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 text-dark">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-receipt text-primary me-2"></i> Bukti Transfer</h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            @php
                                $filePath = $payment->proof_file;
                                $isPdf = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'pdf';
                            @endphp

                            @if($isPdf)
                                <!-- PDF Document Preview Frame -->
                                <div class="border rounded p-4 bg-light d-flex flex-column align-items-center justify-content-center mb-3" style="min-height: 200px;">
                                    <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                    <h6 class="fw-bold mb-1 text-dark">Dokumen Bukti Transfer (PDF)</h6>
                                    <small class="text-muted mb-3">Klik tombol di bawah untuk membuka berkas PDF</small>
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka File PDF
                                    </a>
                                </div>
                            @else
                                <!-- Image Preview Container -->
                                <div class="border rounded bg-light overflow-hidden mb-3 p-1 position-relative" style="min-height: 200px;">
                                    <img src="{{ asset('storage/' . $filePath) }}" class="img-fluid rounded shadow-sm border" style="max-height: 320px; width: 100%; object-fit: contain; background: #fff;">
                                </div>
                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 rounded-pill fw-bold">
                                    <i class="fas fa-search-plus me-1"></i> Perbesar Bukti Transfer
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>