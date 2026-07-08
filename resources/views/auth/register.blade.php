<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <div class="auth-card" style="max-width: 580px;">
        <!-- Header -->
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/logo.png') }}" alt="MindFit Logo"
                style="height: 48px; width: 48px; object-fit: contain; margin-bottom: 12px;">
            <h4 class="fw-bold mb-1" style="color: var(--text-dark); letter-spacing: -0.5px;">Buat Akun MindFit</h4>
            <p class="text-muted small mb-0">Mulai perjalanan kebugaranmu dalam hitungan detik.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Nama Lengkap & Email (Baris 1) -->
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            class="form-control border-start-0 @error('name') is-invalid @enderror"
                            placeholder="Nama Lengkap Anda" required autofocus>
                    </div>
                    @error('name')
                        <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                            placeholder="nama@example.com" required>
                    </div>
                    @error('email')
                        <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="form-group mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-venus-mars"></i>
                    </span>
                    <select id="gender" name="gender" class="form-select border-start-0 @error('gender') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki (Male)</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan (Female)</option>
                    </select>
                </div>
                @error('gender')
                    <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password & Konfirmasi Password (Baris 2) -->
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required>
                        <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon" style="color: #94a3b8;"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger d-block mt-1" style="font-size: 0.78rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control border-start-0 border-end-0" placeholder="Ulangi password" required>
                        <span class="input-group-text" style="cursor: pointer;" id="togglePasswordConfirmation">
                            <i class="fas fa-eye" id="eyeIconConfirmation" style="color: #94a3b8;"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                    Masuk Disini
                </a>
            </p>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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