<x-app-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="row">
        <div class="col-md-6 mb-4">
            {{-- PROFILE INFORMATION --}}
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <div class="card-title fw-bold text-dark"><i class="fas fa-user-edit text-primary me-2"></i>Edit Profil</div>
                </div>
                <div class="card-body px-4 pb-4">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Avatar Section --}}
                        <div class="form-group text-center mb-4">
                            <div class="avatar-picker-container d-inline-block position-relative">
                                <div class="avatar avatar-xxl mb-2 shadow-sm border border-4 border-white rounded-circle overflow-hidden bg-light" style="width: 110px; height: 110px; margin: 0 auto;">
                                    <img id="avatarPreview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('kaiadmin/img/profile.jpg') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('kaiadmin/img/profile.jpg') }}';"
                                        alt="image profile" class="avatar-img w-100 h-100 object-fit-cover rounded-circle">
                                </div>
                                <div class="upload-badge bg-primary text-white rounded-circle position-absolute bottom-0 end-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; border: 2px solid white; transform: translate(-10px, -10px); cursor: pointer;" onclick="document.getElementById('avatarInput').click();">
                                    <i class="fas fa-camera fa-xs"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="avatarInput" class="form-label text-muted small fw-bold">Ganti Foto Profil</label>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*,.heic,.heif" class="form-control form-control-sm mx-auto" style="max-width: 280px;" onchange="previewAvatar(this)">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, HEIC, HEIF, WEBP (Maksimal 5MB)</small>
                                @error('avatar') <span class="text-danger d-block mt-1 small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end pt-3">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            {{-- UPDATE PASSWORD --}}
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <div class="card-title fw-bold text-dark"><i class="fas fa-lock text-warning me-2"></i>Ganti Password</div>
                </div>
                <div class="card-body px-4 pb-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" autocomplete="current-password">
                            @error('current_password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Password Baru</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                            @error('password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end pt-3">
                            <button type="submit" class="btn btn-warning px-4 rounded-pill text-white">
                                <i class="fas fa-key me-1"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('avatarPreview');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>