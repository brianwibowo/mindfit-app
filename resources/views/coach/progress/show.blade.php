<x-app-layout>
    <x-slot name="header">Detail Progress Klien</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-title">Detail Log: {{ $log->client->name }}</div>
                    <div>
                        <a href="{{ route('coach.progress.pdf', $log->id) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                        </a>
                        <a href="{{ route('coach.progress.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $log->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Log</th>
                                    <td><span class="badge badge-info">{{ ucfirst($log->type) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Berat Badan</th>
                                    <td>{{ $log->weight ? $log->weight . ' Kg' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lingkar Pinggang</th>
                                    <td>{{ $log->waist ? $log->waist . ' cm' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tinggi Badan</th>
                                    <td>{{ $log->height ? $log->height . ' cm' : '-' }}</td>
                                </tr>
                            </table>

                            <hr>
                            <h6>Catatan Klien:</h6>
                            <div class="p-3 bg-light rounded mb-3">
                                <i>"{{ $log->description ?: 'Tidak ada catatan.' }}"</i>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            @if($log->photo)
                                <h6>Foto Fisik</h6>
                                <img src="{{ asset('storage/' . $log->photo) }}" class="img-fluid rounded border mb-2"
                                    style="max-height: 250px;">
                                <br>
                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-search-plus"></i> Zoom
                                </a>
                            @else
                                <div class="alert alert-light mt-4">
                                    <i class="fas fa-camera-retro fa-2x mb-3 text-muted"></i>
                                    <p class="text-muted">Tidak ada foto.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- FEEDBACK SECTION --}}
                    <div class="mt-4">
                        <h5 class="text-primary mb-3"><i class="fas fa-comment-dots"></i> Feedback Coach</h5>

                        {{-- DISPLAY MODE: Show if feedback exists --}}
                        @if($log->coach_note)
                            <div id="feedback-display">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Feedback Tersimpan:</strong>
                                        <p class="mb-0 mt-2" style="white-space: pre-line;">"{{ $log->coach_note }}"</p>
                                    </div>
                                    <button class="btn btn-sm btn-outline-success" onclick="toggleEditFeedback()">
                                        <i class="fas fa-edit"></i> Edit Feedback
                                    </button>
                                </div>
                            </div>
                        @else
                            <div id="feedback-empty" class="alert alert-warning">Belum ada feedback. Silakan isi form di bawah.</div>
                        @endif

                        {{-- EDIT FORM: Hidden by default if feedback exists --}}
                        <div id="feedback-form" style="{{ $log->coach_note ? 'display: none;' : '' }}">
                            <div class="card border border-primary shadow-none">
                                <div class="card-body p-3">
                                    <form action="{{ route('coach.progress.update', $log->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group mb-3 p-0">
                                            <label class="fw-bold mb-2">Tulis Catatan / Masukan Anda:</label>
                                            <textarea name="coach_note" class="form-control" rows="4" required
                                                placeholder="Berikan semangat atau evaluasi...">{{ old('coach_note', $log->coach_note) }}</textarea>
                                        </div>
                                        <div class="form-group text-end d-flex justify-content-end gap-2 p-0">
                                            @if($log->coach_note)
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    onclick="toggleEditFeedback()">Batal</button>
                                            @endif
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-save me-1"></i> Simpan Feedback
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- CHART SECTION & SUMMARY --}}
    <div class="row mt-2">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-title"><i class="fas fa-chart-line text-primary me-2"></i> Grafik Perkembangan: {{ $log->client->name }}</div>
                    <p class="card-category">Pantau trend berat badan, tinggi badan, dan lingkar pinggang klien ini sepanjang waktu.</p>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="progressChart"></canvas>
                    </div>
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
                    $narrative .= "Indeks Massa Tubuh (BMI) klien saat ini berada di angka " . number_format($bmi, 1) . " (" . $bmiStatus . "). ";
                }
                
                if ($weightChange !== null) {
                    if ($weightChange < 0) {
                        $narrative .= "Klien telah berhasil mengurangi berat badan sebesar " . abs(number_format($weightChange, 1)) . " kg sejak awal program. ";
                    } elseif ($weightChange > 0) {
                        $narrative .= "Berat badan klien naik sebesar " . number_format($weightChange, 1) . " kg. Harap pelatih menyesuaikan target nutrisi harian klien. ";
                    } else {
                        $narrative .= "Berat badan klien stabil tanpa kenaikan maupun penurunan. ";
                    }
                }

                if ($waistChange !== null) {
                    if ($waistChange < 0) {
                        $narrative .= "Lingkar pinggang menyusut sebanyak " . abs(number_format($waistChange, 1)) . " cm, menunjukkan respons pembakaran lemak perut yang baik. ";
                    } elseif ($waistChange > 0) {
                        $narrative .= "Lingkar pinggang klien bertambah sebanyak " . number_format($waistChange, 1) . " cm. Perlu evaluasi nutrisi dan penambahan latihan kardio harian. ";
                    }
                }

                if (empty($narrative)) {
                    $narrative = "Belum ada riwayat pengukuran fisik yang cukup untuk menyusun evaluasi otomatis.";
                } else {
                    $narrative .= "Rekomendasi coach: " . ($bmi >= 25 ? "Kurangi porsi karbohidrat sederhana dan perbanyak porsi sayur serta kardio." : "Fokus pada surplus kalori bersih dan asupan protein untuk memicu hipertrofi otot.");
                }
            @endphp

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
                        <h6 class="fw-bold mb-1 text-primary"><i class="fas fa-magic me-1"></i> Analisis Progres Klien</h6>
                        <p class="mb-0 text-muted">{{ $narrative }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleEditFeedback() {
                var displayDiv = document.getElementById('feedback-display');
                var formDiv = document.getElementById('feedback-form');
                var emptyDiv = document.getElementById('feedback-empty');

                if (displayDiv && displayDiv.style.display === 'none') {
                    displayDiv.style.display = 'block';
                    formDiv.style.display = 'none';
                } else {
                    if (displayDiv) displayDiv.style.display = 'none';
                    if (emptyDiv) emptyDiv.style.display = 'none';
                    formDiv.style.display = 'block';
                }
            }
        </script>

        {{-- ChartJS Logic --}}
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