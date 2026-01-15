<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Buat Sesi Baru</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.sessions.index') }}">Monitoring Sesi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Buat Baru</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Jadwal Sesi</div>
                </div>
                <form action="{{ route('admin.sessions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Coach / Nutritionist</label>
                            <select class="form-select form-control" name="coach_id" required>
                                <option value="">-- Pilih Coach --</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}">{{ $coach->name }} ({{ ucfirst($coach->role) }} -
                                        {{ ucfirst($coach->specialization) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pilih Klien</label>
                            <select class="form-select form-control" name="client_id" required>
                                <option value="">-- Pilih Klien --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Waktu</label>
                                    <input type="time" class="form-control" name="time" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Judul Sesi</label>
                            <input type="text" class="form-control" name="title"
                                placeholder="Contoh: Consultation Week 1" required>
                        </div>

                        <div class="form-group">
                            <label>Tipe Sesi</label>
                            <select class="form-select form-control" name="type" required>
                                <option value="online">Online (Google Meet/Zoom)</option>
                                <option value="offline">Offline (Tatap Muka)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Catatan / Link Meeting</label>
                            <textarea class="form-control" name="notes" rows="3"
                                placeholder="Masukkan link meeting atau lokasi pertemuan"></textarea>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>