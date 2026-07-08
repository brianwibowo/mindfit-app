<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <div class="row">
        <div class="col-12">
            <div class="row">
                {{-- Card 1: Total Klien --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Klien</p>
                                        <h4 class="card-title">{{ $totalMembers }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Menunggu Verifikasi --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Perlu Verifikasi</p>
                                        <h4 class="card-title">{{ $verificationNeeded }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Klien Aktif --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Klien Aktif</p>
                                        <h4 class="card-title">{{ $activeClients }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Total Pendapatan --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="fas fa-wallet text-white"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Pendapatan</p>
                                        <h4 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 1.18rem; font-weight: 700;">
                                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 1. REGISTRATION TREND CHART (FULL WIDTH) --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                                <div>
                                    <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Pertumbuhan Klien Baru</h4>
                                    <small class="text-muted">{{ $chartTitle }}</small>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                                    <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'week']) }}"
                                        class="btn btn-xs btn-round px-3 py-1.5 fw-semibold {{ $chartFilter == 'week' ? 'btn-primary' : 'btn-outline-primary border-0' }}"
                                        style="{{ $chartFilter == 'week' ? 'background-color: #5c55e3; border-color: #5c55e3; box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2);' : '' }}">
                                        Minggu
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'month']) }}"
                                        class="btn btn-xs btn-round px-3 py-1.5 fw-semibold {{ $chartFilter == 'month' ? 'btn-primary' : 'btn-outline-primary border-0' }}"
                                        style="{{ $chartFilter == 'month' ? 'background-color: #5c55e3; border-color: #5c55e3; box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2);' : '' }}">
                                        Bulan
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'year']) }}"
                                        class="btn btn-xs btn-round px-3 py-1.5 fw-semibold {{ $chartFilter == 'year' ? 'btn-primary' : 'btn-outline-primary border-0' }}"
                                        style="{{ $chartFilter == 'year' ? 'background-color: #5c55e3; border-color: #5c55e3; box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2);' : '' }}">
                                        Tahun
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="chart-container" style="min-height: 280px; position: relative;">
                                <canvas id="registrationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. RECENT TRANSACTIONS (FULL WIDTH) --}}
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                            <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Riwayat Transaksi Terbaru</h4>
                            <small class="text-muted">Daftar pembayaran paket klien yang terakhir masuk ke sistem.</small>
                        </div>
                        <div class="card-body px-4 pb-4 pt-1">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">KLIEN</th>
                                            <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">PAKET PILIHAN</th>
                                            <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TOTAL BAYAR</th>
                                            <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px; text-align: center;">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentTransactions as $t)
                                            <tr>
                                                <td style="padding: 12px 8px;">
                                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $t->user->name ?? 'N/A' }}</span><br>
                                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $t->created_at->format('d M Y, H:i') }} WIB</small>
                                                </td>
                                                <td style="padding: 12px 8px;">
                                                    <span class="fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $t->package_data['package_name'] ?? 'Kustom / Lainnya' }}</span>
                                                </td>
                                                <td style="padding: 12px 8px;" class="fw-bold text-dark">
                                                    Rp {{ number_format($t->package_data['total_price'] ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td style="padding: 12px 8px;" class="text-center">
                                                    @if($t->status == 'approved')
                                                        <span class="badge" style="font-size: 0.7rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(46, 204, 113, 0.1); color: #2ecc71;">Approved</span>
                                                    @elseif($t->status == 'pending')
                                                        <span class="badge" style="font-size: 0.7rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(241, 196, 15, 0.1); color: #f1c40f;">Pending</span>
                                                    @else
                                                        <span class="badge" style="font-size: 0.7rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(231, 76, 60, 0.1); color: #e74c3c;">Rejected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat transaksi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // 1. Client Registrations Chart
            var ctxReg = document.getElementById('registrationChart').getContext('2d');
            
            var regGradient = ctxReg.createLinearGradient(0, 0, 0, 300);
            regGradient.addColorStop(0, 'rgba(92, 85, 227, 0.25)');
            regGradient.addColorStop(1, 'rgba(92, 85, 227, 0.01)');

            var registrationChart = new Chart(ctxReg, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Pendaftaran Klien Baru',
                        borderColor: "#5c55e3",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#5c55e3",
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: regGradient,
                        fill: true,
                        borderWidth: 2.5,
                        data: @json($registrations),
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#8d94a5'
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.04)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#8d94a5'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>