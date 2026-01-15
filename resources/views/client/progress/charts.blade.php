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
                            <a href="{{ route('client.progress.index') }}" class="btn btn-primary">Catat Progress
                                Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('progressChart');
                if (ctx) {
                    const logs = @json($logs);

                    // Logs already sorted ASC from controller
                    const labels = logs.map(log => new Date(log.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                    const weights = logs.map(log => log.weight);
                    const waists = logs.map(log => log.waist);

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
                                    title: { display: true, text: 'Pinggang (cm)' }
                                },
                            },
                            plugins: {
                                legend: { display: true, position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += context.parsed.y;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>