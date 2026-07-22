<x-app-layout>
    <x-slot name="header">Catat Progress Harian/Mingguan</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Input Progress</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.progress.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Pencatatan</label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Log</label>
                                    <select name="type" class="form-control" required>
                                        <option value="body_check">Body Check (Berat/Foto)</option>
                                        <option value="workout">Laporan Workout</option>
                                        <option value="nutrition">Laporan Nutrisi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Berat Badan (kg)</label>
                                    <input type="number" step="0.1" name="weight" class="form-control"
                                        placeholder="Contoh: 65.5">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lingkar Pinggang (cm)</label>
                                    <input type="number" step="0.1" name="waist" class="form-control"
                                        placeholder="Opsional">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tinggi Badan (cm)</label>
                                    <input type="number" step="0.1" name="height" class="form-control"
                                        placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Foto Kondisi Fisik (Opsional)</label>
                            <input type="file" name="photo" id="photo" accept="image/*,.heic,.heif" class="form-control">
                            <small class="text-muted">Format: JPG, PNG, GIF, HEIC, HEIF, WEBP. Maks 5MB.</small>
                        </div>

                        <div class="form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Bagaimana perasaanmu? Ada keluhan?"></textarea>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-primary">Simpan Progress</button>
                            <a href="{{ route('client.progress.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>