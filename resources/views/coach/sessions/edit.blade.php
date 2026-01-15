<x-app-layout>
    <x-slot name="header">Edit Sesi Coaching</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Jadwal Sesi</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('coach.sessions.update', $session->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Klien</label>
                            <input type="text" class="form-control" value="{{ $session->client->name }}" readonly>
                            <small class="text-muted">Klien tidak dapat diubah pada mode edit.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ $session->date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jam</label>
                                    <input type="time" name="time" class="form-control"
                                        value="{{ $session->date->format('H:i') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Judul Sesi</label>
                            <input type="text" name="title" class="form-control" value="{{ $session->title }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tipe Sesi</label>
                            <select name="type" class="form-control" required>
                                <option value="online" {{ $session->type == 'online' ? 'selected' : '' }}>Online (Google
                                    Meet / Zoom)</option>
                                <option value="offline" {{ $session->type == 'offline' ? 'selected' : '' }}>Offline (Tatap
                                    Muka)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Catatan / Link Meeting</label>
                            <textarea name="notes" class="form-control" rows="3"
                                placeholder="Masukkan link meeting atau lokasi...">{{ $session->notes }}</textarea>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('coach.sessions.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>