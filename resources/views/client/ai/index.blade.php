<x-app-layout>
    <x-slot name="header">Fitur AI (MindFit Intelligence)</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-robot"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Status Fitur</p>
                                <h4 class="card-title">Coming Soon</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center" style="padding: 50px;">
                    <img src="{{ asset('kaiadmin/img/kaiadmin/logo_light.svg') }}" alt="AI"
                        style="height: 50px; margin-bottom: 20px; opacity: 0.5">
                    <h2>Fitur AI Sedang Dalam Pengembangan</h2>
                    <p class="text-muted">Kami sedang melatih model AI untuk memberikan rekomendasi latihan dan nutrisi
                        terbaik untuk Anda.</p>
                    <button class="btn btn-secondary btn-round" disabled>Nantikan Segera!</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>