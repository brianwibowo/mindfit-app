<x-guest-layout>
    <x-slot name="title">Verifikasi Email</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <h4 class="fw-bold mb-2">Verifikasi Email</h4>
                <p class="text-muted small">Terima kasih telah mendaftar! Sebelum memulai, verifikasi email Anda dengan mengklik link yang telah kami kirimkan ke email Anda.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="d-grid gap-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-sign-out-alt me-2"></i>Keluar
                    </button>
                </form>
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted small mb-0">
                    Belum menerima email? Cek folder spam atau kirim ulang email verifikasi.
                </p>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</x-guest-layout>