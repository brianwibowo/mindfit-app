<x-app-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="row">
        <div class="col-md-8">
            {{-- PROFILE INFORMATION --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profil</div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Avatar --}}
                        <div class="form-group text-center">
                            <div class="avatar-lg mx-auto mb-3">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('kaiadmin/img/profile.jpg') }}"
                                    alt="image profile" class="avatar-img rounded-circle">
                            </div>
                            <label>Ganti Foto Profil</label>
                            <input type="file" name="avatar" class="form-control">
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="card-action">
                            <button class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- UPDATE PASSWORD --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Ganti Password</div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control"
                                autocomplete="current-password">
                            @error('current_password', 'updatePassword') <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                            @error('password', 'updatePassword') <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword') <span
                            class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="card-action">
                            <button class="btn btn-warning">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>