<x-app-layout>
    <x-slot name="header">Edit Coach</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Edit Coach</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.update', $coach->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Coach</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $coach->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $coach->email) }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Contoh: 08123456789" value="{{ old('phone', $coach->phone) }}" required>
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Spesialisasi</label>
                            <select name="specialization" class="form-control" required>
                                <option value="fitness" {{ $coach->specialization == 'fitness' ? 'selected' : '' }}>
                                    Fitness Coach</option>
                                <option value="nutritionist" {{ $coach->specialization == 'nutritionist' ? 'selected' : '' }}>Nutritionist</option>
                            </select>
                            @error('specialization') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="avatar">Foto Profil (Avatar)</label>
                            @if($coach->avatar)
                                <div class="avatar avatar-xl mb-3 overflow-hidden border border-2 border-primary rounded-circle" style="width: 80px; height: 80px;">
                                    <img src="{{ asset('storage/' . $coach->avatar) }}" alt="avatar" class="w-100 h-100 object-fit-cover rounded-circle">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            <small class="text-muted d-block mt-1">Format: jpeg, png, jpg, gif (Max 2MB). Biarkan kosong jika tidak diubah.</small>
                            @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_active">Status Keaktifan</label>
                            <select name="is_active" id="is_active" class="form-control" required>
                                <option value="1" {{ $coach->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$coach->is_active ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('is_active') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password Baru">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password Baru">
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update Data</button>
                            <a href="{{ route('admin.coaches.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>