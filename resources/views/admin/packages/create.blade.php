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
                            <label>Thumbnail</label>
                            <input type="file" name="image" class="form-control">
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
            document.querySelector('input[name="image"]').addEventListener('change', function (e) {
                const file = this.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                        this.value = ''; // Reset
                    } else {
                        // Optional: Show preview or success indicator
                        // alert('File siap diupload: ' + file.name);
                    }
                }
            });

            document.querySelector('form').addEventListener('submit', function () {
                const btn = document.getElementById('btnSubmit');
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';
                btn.disabled = true;
            });
        </script>
    @endpush
</x-app-layout>