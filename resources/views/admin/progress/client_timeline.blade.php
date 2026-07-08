{{--
    Admin Client Timeline View
    Shows all progress logs for a specific client with chart, summary, and paginated table.
    Route: admin/monitor-progress/client/{clientId}
--}}
<x-app-layout>
    <x-slot name="header">Timeline Progress: {{ $client->name }}</x-slot>

    @php
        /* ── Coaches assigned to this client ── */
        $pt = $client->coaches->where('specialization', 'fitness')->first();
        $nutritionist = $client->coaches->where('specialization', 'nutritionist')->first();

        /* ── Summary statistics from all logs ── */
        $latestHeightLog = $chartLogs->where('height', '>', 0)->last();
        $latestHeight    = $latestHeightLog ? $latestHeightLog->height : null;

        $latestWeightLog = $chartLogs->where('weight', '>', 0)->last();
        $latestWeight    = $latestWeightLog ? $latestWeightLog->weight : null;

        $latestWaistLog = $chartLogs->where('waist', '>', 0)->last();
        $latestWaist    = $latestWaistLog ? $latestWaistLog->waist : null;

        /* ── BMI calculation ── */
        $bmi = null; $bmiStatus = ''; $bmiClass = '';
        if ($latestHeight && $latestWeight) {
            $bmi = $latestWeight / (($latestHeight / 100) ** 2);
            if ($bmi < 18.5) { $bmiStatus = 'Underweight'; $bmiClass = 'bg-warning text-dark'; }
            elseif ($bmi < 25) { $bmiStatus = 'Normal'; $bmiClass = 'bg-success text-white'; }
            elseif ($bmi < 30) { $bmiStatus = 'Overweight'; $bmiClass = 'bg-warning text-dark'; }
            else { $bmiStatus = 'Obesitas'; $bmiClass = 'bg-danger text-white'; }
        }

        /* ── Weight & Waist deltas (earliest vs latest) ── */
        $earliestWeight = $chartLogs->where('weight', '>', 0)->first()?->weight;
        $weightChange   = ($earliestWeight && $latestWeight) ? $latestWeight - $earliestWeight : null;

        $earliestWaist = $chartLogs->where('waist', '>', 0)->first()?->waist;
        $waistChange   = ($earliestWaist && $latestWaist) ? $latestWaist - $earliestWaist : null;

        /* ── Review stats ── */
        $totalLogs    = $chartLogs->count();
        $reviewedLogs = $chartLogs->whereNotNull('coach_note')->count();
        $pendingLogs  = $totalLogs - $reviewedLogs;

        /* ── Narrative Analysis generation ── */
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

        /* ── Avatar initials ── */
        $nameParts = explode(' ', trim($client->name));
        $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
        $avatarColors = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'];
        $avatarBg = $avatarColors[$client->id % count($avatarColors)];
    @endphp

    {{-- ── Breadcrumb ── --}}
    <div class="page-header">
        <h4 class="page-title">Timeline Progress Klien</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="{{ route('admin.progress.index', ['view' => 'clients']) }}">Monitoring Progress</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">{{ $client->name }}</a></li>
        </ul>
    </div>

    {{-- ══════════════════════════════════════════════
        ROW 1: Client Profile Card + Summary Stats
    ══════════════════════════════════════════════ --}}
    <div class="row align-items-stretch mb-4">
        {{-- Left: Client Info Card --}}
        <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body text-center p-4">
                    {{-- Avatar --}}
                    @if($client->avatar)
                        <img src="{{ asset('storage/' . $client->avatar) }}" class="rounded-circle mb-3"
                            style="width: 80px; height: 80px; object-fit: cover; border: 3px solid {{ $avatarBg }}33;">
                    @else
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold mb-3"
                            style="width: 80px; height: 80px; font-size: 1.5rem; background: {{ $avatarBg }};">
                            {{ $initials }}
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">{{ $client->name }}</h5>
                    <p class="text-muted text-sm mb-3">{{ $client->email }}</p>

                    {{-- Coaches --}}
                    <div class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                        @if($pt)
                            <span class="badge bg-primary text-white" style="font-size: 0.75rem; border-radius: 20px;">
                                <i class="fa fa-dumbbell me-1"></i> {{ $pt->name }}
                            </span>
                        @endif
                        @if($nutritionist)
                            <span class="badge bg-success text-white" style="font-size: 0.75rem; border-radius: 20px;">
                                <i class="fa fa-apple-alt me-1"></i> {{ $nutritionist->name }}
                            </span>
                        @endif
                        @if(!$pt && !$nutritionist)
                            <span class="badge bg-secondary" style="font-size: 0.75rem; border-radius: 20px;">Belum ada Coach</span>
                        @endif
                    </div>

                    {{-- Quick stats --}}
                    <div class="row text-center g-2 mt-2">
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <span class="d-block fw-bold text-primary" style="font-size: 1.3rem;">{{ $totalLogs }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">Total Log</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <span class="d-block fw-bold text-success" style="font-size: 1.3rem;">{{ $reviewedLogs }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">Reviewed</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <span class="d-block fw-bold {{ $pendingLogs > 0 ? 'text-warning' : 'text-muted' }}" style="font-size: 1.3rem;">{{ $pendingLogs }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">Pending</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Visual Summary (BMI, Weight, Waist, Height) --}}
        <div class="col-lg-8 col-md-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-th-large text-primary me-2"></i> Ringkasan Perkembangan</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row text-center">
                        {{-- BMI --}}
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                    style="width: 50px; height: 50px; background-color: rgba(29, 122, 243, 0.1);">
                                    <i class="fas fa-heartbeat fa-lg text-primary"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">BMI</p>
                                @if($bmi)
                                    <h3 class="fw-bold mb-1">{{ number_format($bmi, 1) }}</h3>
                                    <span class="badge {{ $bmiClass }} px-2 py-1" style="font-size: 11px;">{{ $bmiStatus }}</span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        {{-- Weight Change --}}
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                    style="width: 50px; height: 50px; background-color: rgba(72, 171, 247, 0.1);">
                                    <i class="fas fa-weight fa-lg text-info"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Δ Berat</p>
                                @if($weightChange !== null)
                                    <h3 class="fw-bold mb-1">{{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 1) }} kg</h3>
                                    <span class="fw-bold {{ $weightChange <= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                                        @if($weightChange < 0) <i class="fas fa-arrow-down"></i> Turun
                                        @elseif($weightChange > 0) <i class="fas fa-arrow-up"></i> Naik
                                        @else Stabil @endif
                                    </span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        {{-- Waist Change --}}
                        <div class="col-6 col-md-3 border-end border-light">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                    style="width: 50px; height: 50px; background-color: rgba(49, 206, 54, 0.1);">
                                    <i class="fas fa-ruler-horizontal fa-lg text-success"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Δ Pinggang</p>
                                @if($waistChange !== null)
                                    <h3 class="fw-bold mb-1">{{ $waistChange > 0 ? '+' : '' }}{{ number_format($waistChange, 1) }} cm</h3>
                                    <span class="fw-bold {{ $waistChange <= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                                        @if($waistChange < 0) <i class="fas fa-arrow-down"></i> Menyusut
                                        @elseif($waistChange > 0) <i class="fas fa-arrow-up"></i> Melebar
                                        @else Stabil @endif
                                    </span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>

                        {{-- Height --}}
                        <div class="col-6 col-md-3">
                            <div class="p-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                    style="width: 50px; height: 50px; background-color: rgba(255, 173, 32, 0.1);">
                                    <i class="fas fa-arrows-alt-v fa-lg text-warning"></i>
                                </div>
                                <p class="text-muted mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Tinggi</p>
                                @if($latestHeight)
                                    <h3 class="fw-bold mb-1">{{ number_format($latestHeight, 1) }} cm</h3>
                                    <span class="text-muted small">Tercatat</span>
                                @else
                                    <h3 class="text-muted fw-bold">-</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Narrative Analysis -->
                    <hr class="my-3 border-light">
                    <div class="alert alert-light border mb-0 p-3 text-start" style="font-size: 0.85rem; line-height: 1.6; border-radius: 8px;">
                        <h6 class="fw-bold mb-1 text-primary"><i class="fas fa-magic me-1.5"></i> Analisis Progres Klien</h6>
                        <p class="mb-0 text-muted">{{ $narrative }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
        ROW 2: Chart
    ══════════════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-chart-line text-primary me-2"></i> Grafik Perkembangan</h5>
                    <p class="text-muted text-xs mb-0">Trend berat badan, lingkar pinggang, dan tinggi badan sepanjang waktu.</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="chart-container" style="position: relative; height: 320px;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
        ROW 3: All Logs Table (paginated)
    ══════════════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i> Riwayat Semua Log Harian</h5>
                            <p class="text-muted text-xs mb-0">Menampilkan {{ $logs->total() }} log progress dari klien ini.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TIPE</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">BERAT</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PINGGANG</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TINGGI</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">FOTO</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">REVIEW</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            <strong>{{ $log->date->format('d M Y') }}</strong><br>
                                            <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            @php
                                                $typeBadge = match($log->type) {
                                                    'workout'    => 'badge-primary',
                                                    'nutrition'  => 'badge-success',
                                                    'body_check' => 'badge-info',
                                                    default      => 'badge-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $typeBadge }}">{{ ucfirst(str_replace('_', ' ', $log->type)) }}</span>
                                        </td>
                                        <td>{{ $log->weight ? number_format($log->weight, 1) . ' kg' : '-' }}</td>
                                        <td>{{ $log->waist ? number_format($log->waist, 1) . ' cm' : '-' }}</td>
                                        <td>{{ $log->height ? number_format($log->height, 1) . ' cm' : '-' }}</td>
                                        <td>
                                            @if($log->photo)
                                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank"
                                                    class="badge bg-light text-dark border" style="cursor: pointer;">
                                                    <i class="fa fa-image me-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->coach_note)
                                                <span class="badge bg-success text-white" style="font-size: 0.7rem;" title="{{ $log->coach->name ?? 'Coach' }}: {{ $log->coach_note }}">
                                                    <i class="fa fa-check-circle me-1"></i> Reviewed
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">
                                                    <i class="fa fa-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.progress.show', $log->id) }}" class="btn btn-primary btn-sm btn-round"
                                                title="Lihat detail log ini">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Belum ada progress log untuk klien ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $logs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const logs = @json($chartLogs);
                const chartLogs = logs.filter(l => l.weight > 0 || l.waist > 0 || l.height > 0);

                const labels     = chartLogs.map(l => new Date(l.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                const weightData = chartLogs.map(l => l.weight);
                const waistData  = chartLogs.map(l => l.waist);
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
                                borderWidth: 2, tension: 0.4, fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Lingkar Pinggang (cm)',
                                data: waistData,
                                borderColor: '#f3545d',
                                backgroundColor: 'rgba(243, 84, 93, 0.1)',
                                borderWidth: 2, tension: 0.4, fill: false,
                                yAxisID: 'y1'
                            },
                            {
                                label: 'Tinggi Badan (cm)',
                                data: heightData,
                                borderColor: '#2ecc71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                borderWidth: 2, tension: 0.4, fill: false,
                                borderDash: [3, 3],
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: {
                                type: 'linear', display: true, position: 'left',
                                title: { display: true, text: 'Berat (kg)' }
                            },
                            y1: {
                                type: 'linear', display: true, position: 'right',
                                title: { display: true, text: 'Tinggi & Pinggang (cm)' },
                                grid: { drawOnChartArea: false }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
