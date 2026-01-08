<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <div class="card card-auth shadow">
        <div class="card-body p-4">
            <h4 class="text-center fw-bold mb-4">Daftar Member Baru</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-3 px-0">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                           class="form-control @error('name') is-invalid @enderror" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3 px-0">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3 px-0">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3 px-0">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                           class="form-control" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-round">Daftar</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Login</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>