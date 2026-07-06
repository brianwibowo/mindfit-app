<x-guest-layout>
    <x-slot name="title">Lupa Password</x-slot>

    <div class="auth-card">
        <!-- Header -->
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                style="height: 48px; width: 48px; object-fit: contain; margin-bottom: 12px;">
            <h4 class="fw-bold mb-1" style="color: var(--text-dark); letter-spacing: -0.5px;">Lupa Password?</h4>
            <p class="text-muted small mb-0">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
        </div>

        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
            @csrf

            <!-- Email Address -->
            <div class="form-group mb-4">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control border-start-0 @error('email') is-invalid @enderror"
                        placeholder="nama@example.com" required autofocus>
                </div>
                @error('email')
                <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    Kirim Link Reset <i class="fas fa-paper-plane ms-2"></i>
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-primary text-decoration-none small" style="font-size: 0.85rem;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
            </a>
        </div>
    </div>
</x-guest-layout>