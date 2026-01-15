<x-guest-layout>
    <x-slot name="title">Konfirmasi Password</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <h4 class="fw-bold mb-2">Area Aman</h4>
                <p class="text-muted small">Ini adalah area aman dari aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm">
                @csrf

                <div class="form-group mb-4">
                    <label for="password" class="form-label fw-semibold small text-muted">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror border-0 bg-light"
                            placeholder="Masukkan password" required autocomplete="current-password">
                        <button class="btn bg-light border-start-0 border-end-0" type="button" id="togglePassword"
                            style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold shadow-sm">
                        <i class="fas fa-check me-2"></i>Konfirmasi
                    </button>
                </div>
            </form>
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
        });
    </script>
    @endpush
</x-guest-layout>