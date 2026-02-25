<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <div class="row">
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

            {{-- Card 4: Total Coach --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Coach Tersedia</p>
                                    <h4 class="card-title">{{ $totalCoaches }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART SECTION --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div
                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                            <div class="card-title fw-bold mb-3 mb-md-0" style="line-height:1.2;">{{ $chartTitle }}
                            </div>
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'week']) }}"
                                    class="btn btn-sm {{ $chartFilter == 'week' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Minggu
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'month']) }}"
                                    class="btn btn-sm {{ $chartFilter == 'month' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Bulan
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['chart_filter' => 'year']) }}"
                                    class="btn btn-sm {{ $chartFilter == 'year' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Tahun
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 300px">
                            <canvas id="registrationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('registrationChart').getContext('2d');
            var registrationChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Pendaftaran Baru',
                        borderColor: "#1d7af3",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#1d7af3",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        fill: true,
                        borderWidth: 2,
                        data: @json($registrations)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            fontColor: '#1d7af3',
                        }
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10
                    },
                    layout: {
                        padding: {
                            left: 15,
                            right: 15,
                            top: 15,
                            bottom: 15
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>