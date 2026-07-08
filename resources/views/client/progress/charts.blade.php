<x-app-layout>
    <x-slot name="header">Visualisasi Hasil</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Grafik Perkembangan</div>
                    <div class="card-category">Pantau trend berat badan dan lingkar pinggang Anda.</div>
                </div>
                <div class="card-body">
                    @if($logs->count() > 0)
                        <div class="chart-container mb-4" style="position: relative; height:50vh; width:100%;">
                            <canvas id="progressChart"></canvas>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p>Belum ada data progress untuk ditampilkan grafiknya.</p>
                            <a href="{{ route('client.progress.index') }}" class="btn btn-primary">Catat Progress Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>

            @php
                // Find the latest height logged
                $latestHeightLog = $logs->where('height', '>', 0)->last();
                $latestHeight = $latestHeightLog ? $latestHeightLog->height : null;

                // Find the latest weight and waist logged
                $latestWeightLog = $logs->where('weight', '>', 0)->last();
                $latestWeight = $latestWeightLog ? $latestWeightLog->weight : null;

                $latestWaistLog = $logs->where('waist', '>', 0)->last();
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
                $earliestWeightLog = $logs->where('weight', '>', 0)->first();
                $earliestWeight = $earliestWeightLog ? $earliestWeightLog->weight : null;
                $weightChange = null;
                if ($earliestWeight && $latestWeight) {
                    $weightChange = $latestWeight - $earliestWeight;
                }

                $earliestWaistLog = $logs->where('waist', '>', 0)->first();
                $earliestWaist = $earliestWaistLog ? $earliestWaistLog->waist : null;
                $waistChange = null;
                if ($earliestWaist && $latestWaist) {
                    $waistChange = $latestWaist - $earliestWaist;
                }

                // Generate dynamic narrative analysis text
                $narrative = "";
                if ($bmi) {
                    $narrative .= "Indeks Massa Tubuh (BMI) Anda saat ini berada di angka " . number_format($bmi, 1) . " (" . $bmiStatus . "). ";
                }
                
                if ($weightChange !== null) {
                    if ($weightChange < 0) {
                        $narrative .= "Selamat! Anda telah berhasil mengurangi berat badan sebesar " . abs(number_format($weightChange, 1)) . " kg sejak awal program. ";
                    } elseif ($weightChange > 0) {
                        $narrative .= "Berat badan Anda meningkat sebesar " . number_format($weightChange, 1) . " kg. Harap berkonsultasi dengan coach Anda jika ini di luar target program bulking Anda. ";
                    } else {
                        $narrative .= "Berat badan Anda stabil tanpa kenaikan maupun penurunan. ";
                    }
                }

                if ($waistChange !== null) {
                    if ($waistChange < 0) {
                        $narrative .= "Lingkar pinggang Anda menyusut sebanyak " . abs(number_format($waistChange, 1)) . " cm, menunjukkan berkurangnya lingkar lemak visceral yang baik untuk kesehatan. ";
                    } elseif ($waistChange > 0) {
                        $narrative .= "Lingkar pinggang Anda bertambah sebanyak " . number_format($waistChange, 1) . " cm. Perlu evaluasi nutrisi makanan dan peningkatan latihan kardio harian. ";
                    }
                }

                if (empty($narrative)) {
                    $narrative = "Belum ada riwayat pengukuran fisik yang cukup untuk menyusun evaluasi otomatis.";
                } else {
                    $narrative .= "Rekomendasi coach: " . ($bmi >= 25 ? "Kurangi porsi karbohidrat sederhana dan perbanyak porsi sayur serta kardio." : "Fokus pada surplus kalori bersih dan asupan protein untuk memicu hipertrofi otot.");
                }
            @endphp

            @if($logs->count() > 0)
                <!-- Visual Summary Card -->
                <div class="card mt-3">
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
                            <h6 class="fw-bold mb-1 text-primary"><i class="fas fa-magic me-1"></i> Analisis Progres Anda</h6>
                            <p class="mb-0 text-muted">{{ $narrative }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Pass data from Blade to JavaScript
            window.progressLogs = @json($logs);
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('progressChart');
                if (ctx) {
                    const logs = window.progressLogs || [];

                    // Logs already sorted ASC from controller
                    const labels = logs.map(log => new Date(log.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                    const weights = logs.map(log => log.weight);
                    const waists = logs.map(log => log.waist);
                    const heights = logs.map(log => log.height);

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Berat Badan (Kg)',
                                    data: weights,
                                    borderColor: '#1572e8', // Blue
                                    backgroundColor: 'rgba(21, 114, 232, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    yAxisID: 'y',
                                },
                                {
                                    label: 'Lingkar Pinggang (cm)',
                                    data: waists,
                                    borderColor: '#31ce36', // Green
                                    backgroundColor: 'rgba(49, 206, 54, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    yAxisID: 'y1',
                                },
                                {
                                    label: 'Tinggi Badan (cm)',
                                    data: heights,
                                    borderColor: '#f5b041', // Orange/Yellow
                                    backgroundColor: 'rgba(245, 176, 65, 0.1)',
                                    borderWidth: 2,
                                    borderDash: [3, 3],
                                    tension: 0.4,
                                    yAxisID: 'y1', // Uses right y-axis (cm)
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
                                    title: { display: true, text: 'Berat (Kg)' }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    grid: {
                                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                                    },
                                    title: { display: true, text: 'Tinggi & Pinggang (cm)' }
                                },
                            },
                            plugins: {
                                legend: { display: true, position: 'top' }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>