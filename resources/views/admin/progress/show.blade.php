<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Detail Progress Klien</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.progress.index') }}">Monitoring Progress</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Detail</a>
            </li>
        </ul>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('admin.progress.pdf', $log->id) }}" target="_blank" class="btn btn-outline-primary btn-round">
                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    @php
        // Find the latest height logged
        $latestHeightLog = $clientLogs->where('height', '>', 0)->last();
        $latestHeight = $latestHeightLog ? $latestHeightLog->height : null;

        // Find the latest weight and waist logged
        $latestWeightLog = $clientLogs->where('weight', '>', 0)->last();
        $latestWeight = $latestWeightLog ? $latestWeightLog->weight : null;

        $latestWaistLog = $clientLogs->where('waist', '>', 0)->last();
        $latestWaist = $latestWaistLog ? $latestWaistLog->waist : null;

        // Calculate BMI
        $bmi = null;
        $bmiStatus = '';
        $bmiClass = '';
        if ($latestHeight && $latestWeight) {
            $bmi = $latestWeight / (($latestHeight / 100) ** 2);
            if ($bmi < 18.5) {
                $bmiStatus = 'Kurang (Underweight)';
                $bmiClass = 'bg-warning text-dark';
            } elseif ($bmi < 25) {
                $bmiStatus = 'Normal (Healthy)';
                $bmiClass = 'bg-success text-white';
            } elseif ($bmi < 30) {
                $bmiStatus = 'Berlebih (Overweight)';
                $bmiClass = 'bg-warning text-dark';
            } else {
                $bmiStatus = 'Obesitas';
                $bmiClass = 'bg-danger text-white';
            }
        }

        // Weight and Waist Changes (earliest vs latest)
        $earliestWeightLog = $clientLogs->where('weight', '>', 0)->first();
        $earliestWeight = $earliestWeightLog ? $earliestWeightLog->weight : null;
        $weightChange = null;
        if ($earliestWeight && $latestWeight) {
            $weightChange = $latestWeight - $earliestWeight;
        }

        $earliestWaistLog = $clientLogs->where('waist', '>', 0)->first();
        $earliestWaist = $earliestWaistLog ? $earliestWaistLog->waist : null;
        $waistChange = null;
        if ($earliestWaist && $latestWaist) {
            $waistChange = $latestWaist - $earliestWaist;
        }

        // Generate dynamic narrative analysis text
        $narrative = "";
        if ($bmi) {
            $narrative .= "Indeks Massa Tubuh (BMI) saat ini berada di angka " . number_format($bmi, 1) . " (" . $bmiStatus . "). ";
        }
        
        if ($weightChange !== null) {
            if ($weightChange < 0) {
                $narrative .= "Berat badan telah berkurang sebanyak " . abs(number_format($weightChange, 1)) . " kg sejak pencatatan awal, menunjukkan pembakaran lemak yang konsisten. ";
            } elseif ($weightChange > 0) {
                $narrative .= "Berat badan naik sebanyak " . number_format($weightChange, 1) . " kg. Harap pantau asupan kalori agar selaras dengan target pembentukan otot. ";
            } else {
                $narrative .= "Berat badan stabil tanpa fluktuasi yang berarti. ";
            }
        }

        if ($waistChange !== null) {
            if ($waistChange < 0) {
                $narrative .= "Penyusutan lingkar pinggang sebesar " . abs(number_format($waistChange, 1)) . " cm mengindikasikan berkurangnya lemak visceral perut. ";
            } elseif ($waistChange > 0) {
                $narrative .= "Lingkar pinggang melebar sebanyak " . number_format($waistChange, 1) . " cm. Perlu evaluasi nutrisi dan intensitas latihan kardio. ";
            }
        }

        if (empty($narrative)) {
            $narrative = "Belum ada riwayat pengukuran fisik yang cukup untuk menyusun evaluasi otomatis.";
        } else {
            $narrative .= "Rekomendasi taktis: " . ($bmi >= 25 ? "Jaga defisit kalori ringan dan utamakan latihan pembakaran lemak harian." : "Fokus pada konsumsi protein tinggi untuk mendukung perkembangan massa otot.");
        }
    @endphp

    <div class="row">
        <!-- Detail Log Info (col-md-4) -->
        <div class="col-md-4">
            <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Informasi Log</h5>
                </div>
                <div class="card-body p-4">
                    {{-- Client Avatar & Info --}}
                    <div class="d-flex align-items-center mb-4">
                        @php
                            $nameParts = explode(' ', trim($log->client->name ?? 'N/A'));
                            $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            $avatarBg = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'][$log->client->id % 8];
                        @endphp
                        @if($log->client->avatar ?? false)
                            <img src="{{ asset('storage/' . $log->client->avatar) }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #5c55e344;">
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold me-3" style="width: 50px; height: 50px; font-size: 1.1rem; background: {{ $avatarBg }};">
                                {{ $initials }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $log->client->name ?? '-' }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $log->client->email ?? '-' }}</small>
                        </div>
                    </div>

                    {{-- Metadata Grid (Date & Type) --}}
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="p-2.5 rounded text-start" style="background: rgba(0,0,0,0.02) !important; border-radius: 8px;">
                                <span class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em; margin-bottom: 2px;">TANGGAL LOG</span>
                                <span class="fw-bold text-dark" style="font-size: 0.8rem;">
                                    <i class="far fa-calendar-alt text-primary me-1"></i> {{ $log->date->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2.5 rounded text-start" style="background: rgba(0,0,0,0.02) !important; border-radius: 8px;">
                                <span class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em; margin-bottom: 4px;">TIPE LOG</span>
                                <div>
                                    @if($log->type == 'workout')
                                        <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(92, 85, 227, 0.08);">Workout</span>
                                    @elseif($log->type == 'nutrition')
                                        <span class="badge text-info" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(29, 122, 243, 0.08);">Nutrition</span>
                                    @else
                                        <span class="badge text-success" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(46, 204, 113, 0.08);">Body Check</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Fisik Grid Boxes --}}
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="fas fa-child me-1.5 text-primary"></i> Data Fisik Terukur</h6>
                    <div class="row g-2 mb-4 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 0.68rem;">Berat</small>
                                <strong class="text-dark" style="font-size: 0.85rem;">{{ $log->weight ? $log->weight . ' kg' : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 0.68rem;">Pinggang</small>
                                <strong class="text-dark" style="font-size: 0.85rem;">{{ $log->waist ? $log->waist . ' cm' : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            @php
                                $tb = $log->height ?: ($log->client->clientProfile->height ?? null);
                            @endphp
                            <div class="p-2 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 0.68rem;">Tinggi</small>
                                <strong class="text-dark" style="font-size: 0.85rem;">{{ $tb ? $tb . ' cm' : '-' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan / Keluhan --}}
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="far fa-comment-alt me-1.5 text-primary"></i> Ringkasan / Keluhan</h6>
                    <div class="p-3 rounded border mb-4 text-muted bg-light text-start" style="font-size: 0.82rem; line-height: 1.5; font-style: italic; border-left: 3px solid #5c55e3 !important; border-radius: 4px 8px 8px 4px;">
                        "{{ $log->description ?: 'Tidak ada keluhan yang dilaporkan.' }}"
                    </div>

                    {{-- Foto Fisik --}}
                    @if($log->photo)
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="far fa-image me-1.5 text-primary"></i> Foto Fisik</h6>
                        <div class="position-relative mb-4 text-center rounded" style="overflow: hidden; max-height: 240px; background: #fafafa; border: 1px solid #eee;">
                            <img src="{{ asset('storage/' . $log->photo) }}" class="img-fluid" style="max-height: 240px; object-fit: contain; width: 100%; border-radius: 8px;">
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank" class="btn btn-xs btn-round btn-dark px-2.5 py-1.5" style="box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                                    <i class="fas fa-search-plus"></i> Zoom
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Feedback Coach --}}
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="far fa-comments me-1.5 text-primary"></i> Catatan & Feedback Coach</h6>
                    @if($log->coach_note)
                        <div class="p-3 text-start" style="background-color: rgba(46, 204, 113, 0.05); border-radius: 12px; border: 1px solid rgba(46, 204, 113, 0.15);">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 700; background-color: rgba(46, 204, 113, 0.1); border-radius: 30px; padding: 2px 8px;">
                                    <i class="fas fa-user-check me-1"></i> {{ $log->coach->name ?? 'Coach' }}
                                </span>
                            </div>
                            <p class="mb-0 text-dark" style="font-size: 0.82rem; line-height: 1.5; font-weight: 500;">{{ $log->coach_note }}</p>
                        </div>
                    @else
                        <div class="p-3 text-center" style="background-color: rgba(241, 196, 15, 0.04); border-radius: 12px; border: 1px dashed rgba(241, 196, 15, 0.25) !important;">
                            <span class="text-warning small fw-semibold"><i class="fas fa-hourglass-half me-1"></i> Belum ada feedback dari Coach</span>
                        </div>
                    @endif
                </div>
                <div class="card-footer p-3 bg-transparent border-0 pt-0 text-center">
                    <a href="{{ route('admin.progress.index') }}" class="btn btn-outline-secondary btn-round w-100 fw-semibold text-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Monitoring
                    </a>
                </div>
            </div>
        </div>

        <!-- Charts Section & Summary (col-md-8) -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="card-title">Grafik Perkembangan Klien</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Visual Summary Card (Full width under Grafik card, extending to the right!) -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-th-large text-primary me-2"></i> Ringkasan Perkembangan (Visual Summary)</div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <!-- 1. BMI -->
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary-light text-primary rounded-circle mb-2" style="width: 50px; height: 50px; background-color: rgba(29, 122, 243, 0.1);">
                                    <i class="fas fa-heartbeat fa-lg"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">BMI (Indeks Tubuh)</p>
                                @if($bmi)
                                    <h3 class="fw-bold mb-1">{{ number_format($bmi, 1) }}</h3>
                                    <span class="badge {{ $bmiClass }} px-2 py-1" style="font-size: 11px;">{{ $bmiStatus }}</span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        <!-- 2. Weight Change -->
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center bg-info-light text-info rounded-circle mb-2" style="width: 50px; height: 50px; background-color: rgba(72, 171, 247, 0.1);">
                                    <i class="fas fa-weight fa-lg"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Perubahan Berat</p>
                                @if($weightChange !== null)
                                    <h3 class="fw-bold mb-1">{{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 1) }} kg</h3>
                                    <span class="fw-bold {{ $weightChange <= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                                        @if($weightChange < 0)
                                            <i class="fas fa-arrow-down"></i> Turun
                                        @elseif($weightChange > 0)
                                            <i class="fas fa-arrow-up"></i> Naik
                                        @else
                                            Stabil
                                        @endif
                                    </span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        <!-- 3. Waist Change -->
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center bg-success-light text-success rounded-circle mb-2" style="width: 50px; height: 50px; background-color: rgba(49, 206, 54, 0.1);">
                                    <i class="fas fa-ruler-horizontal fa-lg"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Lingkar Pinggang</p>
                                @if($waistChange !== null)
                                    <h3 class="fw-bold mb-1">{{ $waistChange > 0 ? '+' : '' }}{{ number_format($waistChange, 1) }} cm</h3>
                                    <span class="fw-bold {{ $waistChange <= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                                        @if($waistChange < 0)
                                            <i class="fas fa-arrow-down"></i> Menyusut
                                        @elseif($waistChange > 0)
                                            <i class="fas fa-arrow-up"></i> Melebar
                                        @else
                                            Stabil
                                        @endif
                                    </span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        <!-- 4. Height -->
                        <div class="col-6 col-md-3">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center bg-warning-light text-warning rounded-circle mb-2" style="width: 50px; height: 50px; background-color: rgba(255, 173, 32, 0.1);">
                                    <i class="fas fa-arrows-alt-v fa-lg"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Tinggi Badan</p>
                                @if($latestHeight)
                                    <h3 class="fw-bold mb-1">{{ number_format($latestHeight, 1) }} cm</h3>
                                    <span class="text-muted small">Status Terpantau</span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Narrative Analysis -->
                    <hr class="my-3 border-light">
                    <div class="alert alert-light border mb-0 p-3 text-start" style="font-size: 0.85rem; line-height: 1.6;">
                        <h6 class="fw-bold mb-1 text-primary"><i class="fas fa-magic me-1"></i> Analisis Progres Klien</h6>
                        <p class="mb-0 text-muted">{{ $narrative }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Prepare data from PHP
                const logs = @json($clientLogs);

                // Filter logs with weight, waist, or height for the chart labels
                const chartLogs = logs.filter(l => l.weight > 0 || l.waist > 0 || l.height > 0);

                const labels = chartLogs.map(l => new Date(l.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                const weightData = chartLogs.map(l => l.weight);
                const waistData = chartLogs.map(l => l.waist);
                const heightData = chartLogs.map(l => l.height);

                const ctx = document.getElementById('progressChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Berat Badan (kg)',
                                data: weightData,
                                borderColor: '#1d7af3',
                                backgroundColor: 'rgba(29, 122, 243, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Lingkar Pinggang (cm)',
                                data: waistData,
                                borderColor: '#f3545d',
                                backgroundColor: 'rgba(243, 84, 93, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: false,
                                yAxisID: 'y1'
                            },
                            {
                                label: 'Tinggi Badan (cm)',
                                data: heightData,
                                borderColor: '#2ecc71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                borderWidth: 2,
                                borderDash: [3, 3],
                                tension: 0.4,
                                fill: false,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: { display: true, text: 'Berat (kg)' }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: { display: true, text: 'Tinggi & Lingkar Pinggang (cm)' },
                                grid: {
                                    drawOnChartArea: false,
                                },
                            },
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>