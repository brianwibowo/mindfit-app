<x-app-layout>
    <x-slot name="header">Detail Sesi Coaching</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Detail Sesi</div>
                    <a href="{{ route('coach.sessions.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Judul Sesi</th>
                            <td>{{ $session->title }}</td>
                        </tr>
                        <tr>
                            <th>Klien</th>
                            <td>{{ $session->client->name }} ({{ $session->client->email }})</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $session->date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Waktu</th>
                            <td>{{ $session->date->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <th>Tipe Sesi</th>
                            <td>
                                @if($session->type == 'online')
                                    <span class="badge badge-primary">Online</span>
                                @else
                                    <span class="badge badge-warning">Offline</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($session->date->isPast())
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">Terjadwal</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan / Link</th>
                            <td>
                                @if($session->notes)
                                    <div class="p-2 bg-light rounded border">
                                        {{ $session->notes }}
                                    </div>
                                    @if(filter_var($session->notes, FILTER_VALIDATE_URL))
                                        <div class="mt-2">
                                            <a href="{{ $session->notes }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-external-link-alt"></i> Buka Link
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">- Tidak ada catatan -</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('coach.sessions.edit', $session->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('coach.sessions.destroy', $session->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus sesi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>