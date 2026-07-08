<x-app-layout>
    <x-slot name="header">Tambah Coach</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Tambah Coach</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Coach</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama"
                                required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Contoh: 08123456789" required>
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Spesialisasi</label>
                            <select name="specialization" class="form-control" required>
                                <option value="fitness">Fitness Coach</option>
                                <option value="nutritionist">Nutritionist</option>
                            </select>
                            @error('specialization') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="avatar">Foto Profil (Avatar)</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            <small class="text-muted d-block mt-1">Format: jpeg, png, jpg, gif (Max 2MB)</small>
                            @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_active">Status Keaktifan</label>
                            <select name="is_active" id="is_active" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                            @error('is_active') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password" required>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success">Simpan</button>
                            <a href="{{ route('admin.coaches.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>