<x-app-layout>
    <x-slot name="header">Hasil Analisa AI</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card card-round">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 fw-bold"><i class="fas fa-clipboard-check me-2"></i> HASIL ANALISA KEBUGARAN MINDFIT
                    </h3>
                </div>
                <div class="card-body">

                    {{-- User Stats --}}
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">BMI Check
                                </h6>
                                <h2 class="fw-bold mb-0 text-primary">{{ $result['bmi_value'] }}</h2>
                                <span
                                    class="badge mt-2 {{ $result['bmi_status'] == 'Normal' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $result['bmi_status'] }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">Kalori BMR
                                    (Istirahat)</h6>
                                <h2 class="fw-bold mb-0 text-info">{{ $result['bmr'] ?? '-' }}</h2>
                                <small class="text-muted">kkal/hari</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">TDEE
                                    (Kebutuhan Harian)</h6>
                                <h2 class="fw-bold mb-0 text-success">{{ $result['tdee'] ?? '-' }}</h2>
                                <small class="text-muted">kkal/hari</small>
                            </div>
                        </div>
                    </div>

                    {{-- AI Diagnosis Message --}}
                    <div class="alert alert-info border-info" role="alert">
                        <h4 class="alert-heading fw-bold"><i class="fas fa-robot me-2"></i> DIAGNOSA AI:</h4>
                        <p class="mb-0" style="font-size: 1.1rem; line-height: 1.6;">
                            "{{ $result['pesan'] ?? 'Halo, berdasarkan data yang kamu berikan, kami telah menyusun rekomendasi terbaik untukmu.' }}"
                        </p>
                    </div>

                    {{-- Recommendation Card --}}
                    @if(isset($result['details']))
                        <div class="card border-primary mb-3 mt-4 overflow-hidden" style="border-width: 2px;">
                            <div class="card-header bg-primary text-white text-center py-3">
                                <span class="text-uppercase ls-1" style="font-size: 0.9rem; opacity: 0.9;">Rekomendasi
                                    Terbaik</span>
                                <h2 class="fw-bold mb-0 mt-1">MindFit {{ $result['details']['name'] }}</h2>
                            </div>
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-7 border-end-md">
                                        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-bullseye me-2"></i> Fokus
                                            Program:</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Target:</strong> {{ $result['details']['target'] }}</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Goal:</strong> {{ $result['details']['goal'] }}</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Latihan:</strong> {{ $result['details']['type'] }}</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Nutrisi:</strong> {{ $result['details']['nutrition'] }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 text-center mt-3 mt-md-0">
                                        <h6 class="text-muted text-uppercase fw-bold">Frekuensi</h6>
                                        <h4 class="fw-bold text-dark">{{ $result['details']['freq'] }}</h4>
                                        <hr class="w-50 mx-auto opacity-25">

                                        <h6 class="text-muted text-uppercase fw-bold">Investasi Sehat</h6>
                                        <h2 class="fw-bold text-primary display-6">{{ $result['details']['price'] }}</h2>
                                        <small class="text-muted">per bulan</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3 mt-5">
                                    <a href="{{ route('client.payment.create') }}?package={{ Str::slug($result['details']['name']) }}"
                                        class="btn btn-primary btn-lg btn-round shadow pulse-button px-5">
                                        <i class="fas fa-cart-plus me-2"></i> AMBIL PAKET INI
                                    </a>
                                    <a href="https://wa.me/6281234567890?text=Halo%20Coach,%20saya%20tertarik%20paket%20{{ urlencode($result['details']['name']) }}"
                                        target="_blank" class="btn btn-outline-success btn-lg btn-round">
                                        <i class="fab fa-whatsapp me-2"></i> KONSULTASI DULU
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-center py-3">
                                <small class="text-muted"><i class="fas fa-shield-alt me-1"></i> Garansi bimbingan
                                    profesional oleh Coach tersertifikasi</small>
                            </div>
                        </div>
                    @else
                        {{-- Fallback Card for "Special/Consultation" cases or Error --}}
                        <div class="text-center mt-4">
                            <a href="https://wa.me/6281234567890?text=Halo%20Coach,%20saya%20butuh%20konsultasi%20khusus"
                                class="btn btn-success btn-lg btn-round">
                                <i class="fab fa-whatsapp me-2"></i> HUBUNGI COACH SEKARANG
                            </a>
                        </div>
                    @endif

                    <div class="text-center mt-3 d-flex justify-content-center gap-3">
                        <a href="{{ route('client.ai.history') }}" class="btn btn-outline-secondary btn-round">
                            <i class="fas fa-history me-2"></i> Lihat Riwayat
                        </a>
                        <a href="{{ route('client.ai.index') }}" class="btn btn-outline-primary btn-round">
                            <i class="fas fa-redo me-2"></i> Ulangi Analisa
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .pulse-button {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(29, 122, 243, 0.7);
                }

                70% {
                    transform: scale(1.05);
                    box-shadow: 0 0 0 10px rgba(29, 122, 243, 0);
                }

                100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(29, 122, 243, 0);
                }
            }
        </style>
    @endpush
</x-app-layout>