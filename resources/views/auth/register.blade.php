<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <div class="card card-auth shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                    style="height: 60px; width: 60px; object-fit: contain; margin-bottom: 15px;">
                <h2 class="fw-bold mb-1" style="color: #1a2035;">MINDFIT</h2>
                <p class="text-muted small mb-3">Healthy for Life</p>
                <p class="text-muted">Buat akun MindFit dalam hitungan detik.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="form-label fw-semibold small text-muted">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-primary"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror border-start-0 bg-light"
                            placeholder="Nama Lengkap Anda" required autofocus>
                    </div>
                    @error('name')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror border-start-0 bg-light"
                            placeholder="nama@example.com" required>
                    </div>
                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label fw-semibold small text-muted">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror bg-light border-start-0 border-end-0"
                            placeholder="Minimal 8 karakter" required>
                        <span class="input-group-text bg-light" style="cursor: pointer;" id="togglePassword">
                            <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small text-muted">Konfirmasi
                        Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-check-circle text-primary"></i>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control bg-light border-start-0 border-end-0" placeholder="Ulangi password"
                            required>
                        <span class="input-group-text bg-light" style="cursor: pointer;"
                            id="togglePasswordConfirmation">
                            <i class="fas fa-eye text-muted" id="eyeIconConfirmation"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold shadow-sm">
                        Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none">
                        Masuk Disini
                    </a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Toggle password visibility
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');

                if (togglePassword && passwordInput && eyeIcon) {
                    togglePassword.addEventListener('click', function () {
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
                    togglePasswordConfirmation.addEventListener('click', function () {
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