<x-app-layout>
    <x-slot name="header">Jadwalkan Sesi Baru</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Buat Jadwal untuk: {{ $client->name }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('coach.sessions.store', $client->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Judul Sesi</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="Contoh: Leg Day Workout / Weekly Consultation" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="date" class="form-control" required
                                        min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jam</label>
                                    <input type="time" name="time" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tipe Sesi</label>
                            <select name="type" class="form-control">
                                <option value="online">Online (Zoom/GMeet/Call)</option>
                                <option value="offline">Offline (Gym)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Catatan / Instruksi Tambahan</label>
                            <textarea name="notes" class="form-control" rows="4"
                                placeholder="Instruksi persiapan, link zoom, dll..."></textarea>
                        </div>

                        <div class="card-action">
                            <button class="btn btn-success">Simpan Jadwal</button>
                            <a href="{{ route('coach.dashboard') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>