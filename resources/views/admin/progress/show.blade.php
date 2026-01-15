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
    </div>

    <div class="row">
        <!-- Detail Log Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informasi Log</div>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold">Client</h5>
                    <p>{{ $log->client->name ?? '-' }}</p>

                    <h5 class="fw-bold mt-3">Tanggal Log</h5>
                    <p>{{ $log->date->translatedFormat('d F Y') }}</p>

                    <h5 class="fw-bold mt-3">Tipe</h5>
                    <span class="badge badge-{{ $log->type == 'weight' ? 'primary' : 'info' }}">
                        {{ ucfirst($log->type) }}
                    </span>

                    <h5 class="fw-bold mt-3">Ringkasan / Keluhan</h5>
                    <p>{{ $log->description }}</p>

                    @if($log->photo)
                        <h5 class="fw-bold mt-3">Foto Fisik</h5>
                        <img src="{{ asset('storage/' . $log->photo) }}" class="img-fluid rounded mb-3"
                            alt="Client Progress Photo">
                    @endif

                    <h5 class="fw-bold mt-3">Feedback Coach</h5>
                    @if($log->coach_note)
                        <div class="alert alert-success">
                            <strong>{{ $log->coach->name ?? 'Coach' }}:</strong><br>
                            {{ $log->coach_note }}
                        </div>
                    @else
                        <div class="alert alert-warning">Belum ada feedback dari coach.</div>
                    @endif
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.progress.index') }}" class="btn btn-secondary w-100">Kembali</a>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Grafik Perkembangan Klien</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="progressChart"></canvas>
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

                // Filter only weight/waist logs for chart
                const weightLogs = logs.filter(l => l.weight > 0);

                const labels = weightLogs.map(l => new Date(l.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                const weightData = weightLogs.map(l => l.weight);
                const waistData = weightLogs.map(l => l.waist);

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
                                borderDash: [5, 5],
                                tension: 0.4,
                                fill: false,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
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
                                title: { display: true, text: 'Lingkar Pinggang (cm)' },
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