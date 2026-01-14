<x-app-layout>
    <x-slot name="header">Progress & Capaian Saya</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Riwayat Progress</div>
                    <a href="{{ route('client.progress.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Catat Progress Baru
                    </a>
                </div>
                <div class="card-body">
                    {{-- GRAFIK / CHART --}}
                    @if($logs->count() > 0)
                        <div class="chart-container mb-4" style="position: relative; height:40vh; width:100%;">
                            <canvas id="weightChart"></canvas>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Capaian Fisik</th>
                                    <th>Foto</th>
                                    <th>Tipe/Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->date->format('d M Y') }}</td>
                                        <td>
                                            @if($log->weight)
                                            <div>Berat: <b>{{ $log->weight }} Kg</b></div> @endif
                                            @if($log->waist)
                                            <div>Pinggang: <b>{{ $log->waist }} cm</b></div> @endif
                                            @if(!$log->weight && !$log->waist) <span class="text-muted">-</span> @endif
                                        </td>
                                        <td>
                                            @if($log->photo)
                                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $log->photo) }}" alt="Foto" width="50"
                                                        class="rounded">
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info mb-1">{{ ucfirst($log->type) }}</span>
                                            <p class="small mb-0">{{ Str::limit($log->description, 50) }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada catatan progress. Yuk mulai catat!
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
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('weightChart');
                if (ctx) {
                    const logs = @json($logs);
                    // Sort ascending by date
                    logs.sort((a, b) => new Date(a.date) - new Date(b.date));

                    const labels = logs.map(log => new Date(log.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                    const weights = logs.map(log => log.weight);

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Berat Badan (Kg)',
                                data: weights,
                                borderColor: '#1572e8', // Primary Blue
                                backgroundColor: 'rgba(21, 114, 232, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: false, title: { display: true, text: 'Kg' } }
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