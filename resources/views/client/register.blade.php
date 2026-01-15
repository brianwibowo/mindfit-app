<x-app-layout>
    <x-slot name="header">Pendaftaran Paket Baru</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Pendaftaran</div>
                    <div class="card-category">Silakan lengkapi data di bawah ini untuk memulai langganan baru.</div>
                </div>
                <div class="card-body">
                    {{-- Use the existing partial, but ensure it works stand-alone --}}
                    @include('client.partials.registration-form', ['packages' => $packages, 'user' => Auth::user()])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>