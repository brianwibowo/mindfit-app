<x-app-layout>
    <x-slot name="header">Edit Paket</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Paket: {{ $package->name }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.packages.update', $package) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Paket</label>
                            <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="type" class="form-control">
                                <option value="fitness" {{ $package->type == 'fitness' ? 'selected' : '' }}>Fitness
                                </option>
                                <option value="nutrition" {{ $package->type == 'nutrition' ? 'selected' : '' }}>
                                    Nutritionist</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="price" class="form-control" value="{{ $package->price }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Durasi (Hari)</label>
                                    <input type="number" name="duration_days" class="form-control"
                                        value="{{ $package->duration_days }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi & Fasilitas</label>
                            <textarea name="description" class="form-control" rows="5"
                                required>{{ $package->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail (Biarkan kosong jika tidak ganti)</label>
                            <input type="file" name="image" class="form-control">
                            @if($package->image)
                                <small>Saat ini: <a href="{{ asset('storage/' . $package->image) }}" target="_blank">Lihat
                                        Gambar</a></small>
                            @endif
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}>
                                <span class="form-check-sign">Tampilkan Paket ini di Halaman Pendaftaran</span>
                            </label>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-success">Update Paket</button>
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>