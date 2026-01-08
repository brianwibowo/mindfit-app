<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <div class="card card-auth shadow">
        <div class="card-body p-4">
            <h4 class="text-center fw-bold mb-4">Masuk ke Akun</h4>

            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3 px-0">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3 px-0">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                        @if (Route::has('password.request'))
                            <a class="small text-primary" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">Ingat Saya</label>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-round">Login</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>