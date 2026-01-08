<x-app-layout>
    <x-slot name="header">Dashboard Klien</x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="fw-bold">Halo, {{ Auth::user()->name }}!</h4>
                    <p>Semoga harimu menyenangkan. Jangan lupa latihan hari ini!</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-body">
                    <h5 class="fw-bold">Status Berlangganan</h5>
                    <p>Status: <span class="badge badge-light">Free Member</span></p>
                    <button class="btn btn-outline-light btn-sm">Upgrade ke Premium</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>