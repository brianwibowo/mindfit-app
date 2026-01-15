<x-app-layout>
    <x-slot name="header">Perbaiki Pendaftaran</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Revisi Pendaftaran</div>
                    <div class="card-category">Silakan perbaiki data di bawah ini sesuai catatan admin.</div>
                </div>
                <div class="card-body">
                    @if($payment->admin_note)
                        <div class="alert alert-warning">
                            <b><i class="fas fa-exclamation-circle"></i> Catatan Admin:</b>
                            <p class="mb-0">{{ $payment->admin_note }}</p>
                        </div>
                    @endif

                    @include('client.partials.registration-form', ['payment' => $payment])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>