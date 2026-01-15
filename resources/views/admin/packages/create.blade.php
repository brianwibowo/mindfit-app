<x-app-layout>
    <x-slot name="header">Buat Paket Baru</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Paket</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama Paket</label>
                            <input type="text" name="name" class="form-control" required
                                placeholder="Contoh: Super Shape Up">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="type" class="form-control">
                                <option value="fitness">Fitness</option>
                                <option value="nutrition">Nutritionist</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="price" class="form-control" required placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Durasi (Hari)</label>
                                    <input type="number" name="duration_days" class="form-control" value="30" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi & Fasilitas</label>
                            <textarea name="description" class="form-control" rows="5" required
                                placeholder="Jelaskan benefit paket ini..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail / Gambar Produk (Maks 5 Foto, Total 5MB)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted" id="fileInfo"></small>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-success" id="btnSubmit">Simpan Paket</button>
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