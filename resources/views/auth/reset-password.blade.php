<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <h4 class="fw-bold mb-2">Reset Password</h4>
                <p class="text-muted small">Masukkan password baru Anda untuk mengakses akun kembali.</p>
            </div>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group mb-3">
                    <label for="email" class="form-label fw-semibold small text-muted">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                            class="form-control @error('email') is-invalid @enderror border-start-0 bg-light"
                            placeholder="nama@email.com" required autofocus autocomplete="username">
                        @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label fw-semibold small text-muted">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror border-0 bg-light"
                            placeholder="Minimal 8 karakter" required autocomplete="new-password">
                        <button class="btn bg-light border-start-0 border-end-0" type="button" id="togglePassword"
                            style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small text-muted">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-check-circle text-primary"></i>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control border-0 bg-light"
                            placeholder="Ulangi password baru" required autocomplete="new-password">
                        <button class="btn bg-light border-start-0 border-end-0" type="button"
                            id="togglePasswordConfirmation" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-eye text-muted" id="eyeIconConfirmation"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold shadow-sm">
                        <i class="fas fa-key me-2"></i>Reset Password
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke halaman login
                </a>
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

                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }

            // Toggle password confirmation visibility
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');

            if (togglePasswordConfirmation && passwordConfirmationInput && eyeIconConfirmation) {
                togglePasswordConfirmation.addEventListener('click', function(e) {
                    e.preventDefault();

                    const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirmationInput.setAttribute('type', type);

                    eyeIconConfirmation.classList.toggle('fa-eye');
                    eyeIconConfirmation.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>