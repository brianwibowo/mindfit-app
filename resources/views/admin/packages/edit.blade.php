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
                            <label>Thumbnail / Gambar Produk (Maks 5 Foto)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted" id="fileInfo"></small>

                            @if($package->image)
                                <div class="mt-2">
                                    <label>Gambar Saat Ini:</label>
                                    <div class="d-flex" style="gap: 10px; overflow-x: auto">
                                        @php
                                            $currentImages = json_decode($package->image);
                                            // Handle legacy single string
                                            if (!is_array($currentImages) && $package->image) {
                                                $currentImages = [$package->image];
                                            } elseif (!$currentImages && $package->image) {
                                                $currentImages = [$package->image];
                                            }
                                        @endphp

                                        @if($currentImages)
                                            @foreach($currentImages as $img)
                                                <img src="{{ asset('storage/' . $img) }}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                            @endforeach
                                        @endif
                                    </div>
                                    <small class="text-warning">*Mengupload gambar baru akan menggantikan SEMUA gambar
                                        lama.</small>
                                </div>
                            @endif
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}>
                                <span class="form-check-sign">Tampilkan Paket ini di Halaman Pendaftaran</span>
                            </label>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-success" id="btnSubmit">Update Paket</button>
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('input[name="images[]"]').on('change', function () {
                    var files = this.files;
                    var totalSize = 0;
                    var maxTotalSize = 5 * 1024 * 1024; // 5MB

                    if (files.length > 5) {
                        swal('Error', 'Maksimal upload 5 gambar sekaligus.', 'error');
                        $(this).val('');
                        return;
                    }

                    for (var i = 0; i < files.length; i++) {
                        totalSize += files[i].size;
                    }

                    if (totalSize > maxTotalSize) {
                        swal('Size Limit', 'Total ukuran file terlalu besar! Maksimal 5MB untuk semua gambar.', 'error');
                        $(this).val(''); // Reset
                        $('#fileInfo').text('');
                    } else {
                        $('#fileInfo').text(files.length + ' file dipilih. Total: ' + (totalSize / 1024 / 1024).toFixed(2) + ' MB');
                    }
                });

                $('form').on('submit', function () {
                    var btn = $('#btnSubmit');
                    btn.html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
                    btn.prop('disabled', true);
                });
            });
        </script>
    @endpush
</x-app-layout>