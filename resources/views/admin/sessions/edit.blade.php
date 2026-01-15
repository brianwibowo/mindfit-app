<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Edit Sesi</h4>
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
                <a href="#">Edit</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Edit Sesi</div>
                </div>
                <form action="{{ route('admin.sessions.update', $session->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Coach / Nutritionist</label>
                            <select class="form-select form-control" name="coach_id" required>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}" {{ $session->coach_id == $coach->id ? 'selected' : '' }}>
                                        {{ $coach->name }} ({{ ucfirst($coach->role) }} - {{ ucfirst($coach->specialization) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pilih Klien</label>
                            <select class="form-select form-control" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $session->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="date" value="{{ $session->date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Waktu</label>
                                    <input type="time" class="form-control" name="time" value="{{ $session->date->format('H:i') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Judul Sesi</label>
                            <input type="text" class="form-control" name="title" value="{{ $session->title }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tipe Sesi</label>
                            <select class="form-select form-control" name="type" required>
                                <option value="online" {{ $session->type == 'online' ? 'selected' : '' }}>Online (Google Meet/Zoom)</option>
                                <option value="offline" {{ $session->type == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status Sesi</label>
                            <select class="form-select form-control" name="status" required>
                                <option value="scheduled" {{ $session->status == 'scheduled' ? 'selected' : '' }}>Scheduled (Dijadwalkan)</option>
                                <option value="completed" {{ $session->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="cancelled" {{ $session->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Catatan / Link Meeting</label>
                            <textarea class="form-control" name="notes" rows="3">{{ $session->notes }}</textarea>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
