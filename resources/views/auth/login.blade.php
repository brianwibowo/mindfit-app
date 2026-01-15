<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <h4 class="fw-bold mb-2" style="color: #1a2035;">Selamat Datang!</h4>
                <p class="text-muted">Masuk untuk melanjutkan progress sehatmu.</p>
            </div>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
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

                <div class="form-group mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="password" class="form-label fw-semibold small text-muted mb-0">Password</label>
                        @if (Route::has('password.request'))
                        <a class="small text-primary text-decoration-none"
                            href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror border-0 bg-light"
                            placeholder="Masukkan password" required>
                        <button class="btn bg-light border-start-0 border-end-0" type="button"
                            id="togglePassword" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label text-muted small" for="remember_me">
                        Ingat sesi saya
                    </label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold shadow-sm">
                        Masuk Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-none">
                        Daftar Gratis
                    </a>
                </p>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the eye icon
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>