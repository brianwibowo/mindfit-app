<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <div class="auth-card">
        <!-- Header -->
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                style="height: 48px; width: 48px; object-fit: contain; margin-bottom: 12px;">
            <h4 class="fw-bold mb-1" style="color: var(--text-dark); letter-spacing: -0.5px;">Masuk ke MindFit</h4>
            <p class="text-muted small mb-0">Lanjutkan perjalanan kebugaranmu.</p>
        </div>

        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@example.com" required autofocus>
                </div>
                @error('email')
                <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Password</label>
                    @if (Route::has('password.request'))
                    <a class="text-primary text-decoration-none" style="font-size: 0.78rem; font-weight: 600;"
                        href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password" required>
                    <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon" style="color: #94a3b8;"></i>
                    </span>
                </div>
                @error('password')
                <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label text-muted" style="font-size: 0.82rem;" for="remember_me">
                    Ingat sesi saya
                </label>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    Masuk <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary text-decoration-none">
                    Daftar Gratis
                </a>
            </p>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>