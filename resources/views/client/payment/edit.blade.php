<x-app-layout>
    <x-slot name="header">Perbaiki Pendaftaran</x-slot>

    @if($payment->admin_note)
        <div class="alert alert-warning mb-4 shadow-sm">
            <b><i class="fas fa-exclamation-circle"></i> Catatan Admin:</b>
            <p class="mb-0">{{ $payment->admin_note }}</p>
        </div>
    @endif

    @include('client.partials.registration-form', ['payment' => $payment, 'packages' => $packages, 'user' => $user, 'coaches' => $coaches])
</x-app-layout>