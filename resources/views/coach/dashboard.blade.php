<x-app-layout>
    <x-slot name="header">Dashboard Coach</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="fw-bold">Selamat Datang, Coach {{ Auth::user()->name }}!</h4>
                    <p class="text-muted">Siap membimbing klien hari ini? Cek daftar klien Anda di sidebar.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>