<x-app-layout>
    <x-slot name="header">Manajemen Sesi Coaching</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Daftar Sesi</div>
                    <a href="{{ route('coach.sessions.create') }}" class="btn btn-primary btn-round">
                        <i class="fas fa-plus"></i> Jadwalkan Sesi
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal & Waktu</th>
                                    <th>Klien</th>
                                    <th>Judul Sesi</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Catatan / Link Meeting</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr>
                                        <td>{{ $session->date->format('d M Y, H:i') }}</td>
                                        <td>{{ $session->client->name }}</td>
                                        <td>{{ $session->title }}</td>
                                        <td>
                                            @if($session->type == 'online')
                                                <span class="badge badge-primary">Online</span>
                                            @else
                                                <span class="badge badge-warning">Offline</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($session->date->isPast())
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-secondary">Terjadwal</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($session->notes, 30) ?: '-' }}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('coach.sessions.show', $session->id) }}"
                                                    class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip"
                                                    title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('coach.sessions.edit', $session->id) }}"
                                                    class="btn btn-link btn-warning btn-lg" data-bs-toggle="tooltip"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('coach.sessions.destroy', $session->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus sesi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada sesi yang dijadwalkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>