<x-app-layout>
    <x-slot name="header">Edit Progress</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Edit Log Progress</div>
                        <a href="{{ route('client.progress.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.progress.update', $log->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Pencatatan</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', $log->date->format('Y-m-d')) }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Log</label>
                                    <select name="type" class="form-control" required>
                                        <option value="body_check" {{ old('type', $log->type) == 'body_check' ? 'selected' : '' }}>Body Check (Berat/Foto)</option>
                                        <option value="workout" {{ old('type', $log->type) == 'workout' ? 'selected' : '' }}>Laporan Workout</option>
                                        <option value="nutrition" {{ old('type', $log->type) == 'nutrition' ? 'selected' : '' }}>Laporan Nutrisi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Berat Badan (kg)</label>
                                    <input type="number" step="0.1" name="weight" class="form-control" value="{{ old('weight', $log->weight) }}"
                                        placeholder="Contoh: 65.5">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lingkar Pinggang (cm)</label>
                                    <input type="number" step="0.1" name="waist" class="form-control" value="{{ old('waist', $log->waist) }}"
                                        placeholder="Opsional">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tinggi Badan (cm)</label>
                                    <input type="number" step="0.1" name="height" class="form-control" value="{{ old('height', $log->height) }}"
                                        placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Foto Kondisi Fisik (Opsional)</label>
                            @if($log->photo)
                                <div class="mb-2">
                                    <small class="d-block text-muted">Foto Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $log->photo) }}" height="100" class="rounded border">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Upload foto baru untuk mengganti. Format: JPG, PNG. Maks 2MB.</small>
                        </div>

                        <div class="form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Bagaimana perasaanmu? Ada keluhan?">{{ old('description', $log->description) }}</textarea>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
