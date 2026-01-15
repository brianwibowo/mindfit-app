<x-guest-layout>
    <x-slot name="title">Lupa Password</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <h4 class="fw-bold mb-2">Lupa Password?</h4>
                <p class="text-muted small">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
            </div>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                @csrf

                <div class="form-group mb-4">
                    <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror border-start-0 bg-light"
                            placeholder="nama@example.com" required autofocus>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold shadow-sm">
                        Kirim Link Reset <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</x-guest-layout>