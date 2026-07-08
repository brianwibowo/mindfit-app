<x-app-layout>
    <x-slot name="header">Pendaftaran Paket Baru</x-slot>

    @include('client.partials.registration-form', ['packages' => $packages, 'user' => Auth::user(), 'coaches' => $coaches])
</x-app-layout>