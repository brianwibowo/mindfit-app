<x-app-layout>
    <x-slot name="header">Detail Analisa AI: {{ $analysis->name }}</x-slot>

    <!-- Custom CSS for Premium AI Results View -->
    <style>
        .stat-card {
            border-radius: 12px;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }
        .accordion-button:not(.collapsed) {
            background-color: rgba(92, 85, 227, 0.05) !important;
            color: #5c55e3 !important;
            box-shadow: none !important;
        }
        .accordion-button:focus {
            box-shadow: none !important;
            border-color: rgba(92, 85, 227, 0.2) !important;
        }
        .accordion-item {
            border-radius: 10px !important;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08) !important;
        }
        
        /* Recommendation Card Premium Style */
        .recom-card {
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid rgba(92, 85, 227, 0.15) !important;
            background: #fff;
        }
        .recom-header {
            background: linear-gradient(135deg, #5c55e3, #4840d6) !important;
            padding: 16px 20px !important;
        }
        
        .recom-badge {
            background-color: rgba(46, 204, 113, 0.12) !important; 
            color: #2ecc71 !important;
            border-radius: 30px;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px 12px;
            display: inline-block;
        }
        
        .recom-text-box {
            font-size: 0.9rem;
            line-height: 1.65;
            color: #4a5568;
            background-color: #fafbfe;
            border: 1px solid rgba(92, 85, 227, 0.06);
            border-radius: 10px;
            padding: 20px !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            {{-- Back Button --}}
            <div class="mb-4">
                <a href="{{ route('admin.ai.index') }}" class="btn btn-light btn-round btn-sm px-3.5 border shadow-sm">
                    <i class="fas fa-arrow-left me-2 text-primary"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header bg-white p-4" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold text-dark" style="font-size: 1.15rem;">
                            <i class="fas fa-clipboard-check text-primary me-2"></i> Hasil Analisa: {{ $analysis->name }}
                        </h3>
                        <span class="badge bg-light text-muted border px-2.5 py-1.5" style="font-size: 0.7rem; font-weight: 500; border-radius: 6px;">
                            Dibuat: {{ $analysis->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">

                    {{-- Admin Alert Banner --}}
                    <div class="alert border-0 p-3.5 mb-4" style="background-color: rgba(92, 85, 227, 0.06); border-radius: 10px;">
                        <div class="d-flex gap-2">
                            <i class="fas fa-info-circle text-primary fs-5 mt-0.5"></i>
                            <div>
                                <strong class="text-primary d-block mb-1" style="font-size: 0.88rem;">Informasi Akun Klien</strong>
                                <span class="text-secondary" style="font-size: 0.82rem;">
                                    User: <strong>{{ $analysis->user ? 'Terdaftar (Member)' : 'Tamu / Belum Login' }}</strong>
                                    @if($analysis->user)
                                        | Email: <strong>{{ $analysis->user->email }}</strong>
                                        @if($analysis->user->phone)
                                            | No. HP: <strong>{{ $analysis->user->phone }}</strong>
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- User BMR / BMI / TDEE Cards --}}
                    <div class="row g-3 text-center mb-4">
                        <div class="col-md-4">
                            <div class="card stat-card bg-light border p-4 h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-2.5" style="font-size: 0.72rem; letter-spacing: 0.05em;">BMI Klien</h6>
                                <h2 class="fw-bold mb-1 text-primary" style="font-size: 1.8rem;">{{ $result['bmi_value'] }}</h2>
                                <div>
                                    @php
                                        $bmiStatus = $result['bmi_status'];
                                        $bmiClass = match($bmiStatus) {
                                            'Normal', 'Ideal' => 'background-color: rgba(46, 204, 113, 0.1); color: #2ecc71;',
                                            'Underweight', 'Kurang' => 'background-color: rgba(241, 196, 15, 0.1); color: #f1c40f;',
                                            default => 'background-color: rgba(231, 76, 60, 0.1); color: #e74c3c;',
                                        };
                                    @endphp
                                    <span class="badge border-0 px-2.5 py-1" style="font-size: 0.7rem; font-weight: 600; border-radius: 30px; {{ $bmiClass }}">
                                        {{ $bmiStatus }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-light border p-4 h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-2.5" style="font-size: 0.72rem; letter-spacing: 0.05em;">Kalori BMR</h6>
                                <h2 class="fw-bold mb-1 text-info" style="font-size: 1.8rem;">{{ $result['bmr'] ?? '-' }}</h2>
                                <small class="text-muted fw-medium">kkal / hari</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-light border p-4 h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-2.5" style="font-size: 0.72rem; letter-spacing: 0.05em;">TDEE Klien</h6>
                                <h2 class="fw-bold mb-1 text-success" style="font-size: 1.8rem;">{{ $result['tdee'] ?? '-' }}</h2>
                                <small class="text-muted fw-medium">kkal / hari</small>
                            </div>
                        </div>
                    </div>

                    {{-- Collapsible User Input Data --}}
                    <div class="accordion mb-4" id="accordionData">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" style="font-size: 0.85rem;">
                                    <i class="fas fa-list me-2"></i> Rincian Formulir Input Data User
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                                <div class="accordion-body p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle mb-0" style="font-size: 0.82rem;">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light fw-bold" style="width: 30%;">Jenis Kelamin</th>
                                                    <td>{{ $payload['jenis_kelamin'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Usia</th>
                                                    <td>{{ $payload['usia'] }} Tahun</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Tinggi / Berat Badan</th>
                                                    <td>{{ $payload['tinggi'] }} cm / {{ $payload['berat'] }} kg</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Riwayat Cedera & Medis</th>
                                                    <td class="text-danger fw-semibold">{{ $payload['riwayatKesehatan'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Frekuensi Olahraga</th>
                                                    <td>{{ $payload['frekuensiOlahraga'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Pengalaman Gym</th>
                                                    <td>{{ $payload['pengalaman'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Pola Makan Sehari-hari</th>
                                                    <td>{{ $payload['polaMakan'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Target Utama</th>
                                                    <td>{{ $payload['targetUtama'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light fw-bold">Keluhan Tambahan</th>
                                                    <td>{{ $payload['keluhan'] ?: '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recommendation Details Card --}}
                    @if(isset($result['details']))
                        <div class="card recom-card mb-0 mt-4 shadow-sm">
                            <div class="card-header recom-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h5 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">
                                    <i class="fas fa-brain me-1.5 text-warning-light"></i> Rekomendasi Program Layanan AI
                                </h5>
                                <span class="recom-badge">
                                    <i class="fas fa-check-circle me-1"></i> Cocok
                                </span>
                            </div>
                            <div class="card-body p-4 text-start">
                                <h4 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">{{ $result['details']['name'] }}</h4>
                                
                                <div class="recom-text-box mb-4">
                                    {!! $result['pesan'] !!}
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-sm-6 text-sm-end border-sm-end pe-sm-4">
                                        <small class="text-muted d-block" style="font-size: 0.72rem; margin-bottom: 2px;">Harga Paket Layanan</small>
                                        <span class="text-primary fw-bold" style="font-size: 1.25rem;">{{ $result['details']['price'] }}</span>
                                    </div>
                                    <div class="col-sm-6 text-sm-start ps-sm-4">
                                        <small class="text-muted d-block" style="font-size: 0.72rem; margin-bottom: 2px;">Frekuensi Latihan / Sesi</small>
                                        <span class="text-dark fw-bold" style="font-size: 1.1rem;">{{ $result['details']['freq'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>