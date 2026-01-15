<x-app-layout>
    <x-slot name="header">Progress & Capaian Saya</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Riwayat Progress</div>
                    <a href="{{ route('client.progress.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Catat Progress Baru
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Capaian Fisik</th>
                                    <th>Foto</th>
                                    <th>Tipe/Catatan</th>
                                    <th width="25%">Catatan Coach</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->date->format('d M Y') }}</td>
                                        <td>
                                            @if($log->weight)
                                            <div>Berat: <b>{{ $log->weight }} Kg</b></div> @endif
                                            @if($log->waist)
                                            <div>Pinggang: <b>{{ $log->waist }} cm</b></div> @endif
                                            @if(!$log->weight && !$log->waist) <span class="text-muted">-</span> @endif
                                        </td>
                                        <td>
                                            @if($log->photo)
                                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $log->photo) }}" alt="Foto" width="50"
                                                        class="rounded">
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info mb-1">{{ ucfirst($log->type) }}</span>
                                            <p class="small mb-0">{{ Str::limit($log->description, 50) }}</p>
                                        </td>
                                        <td>
                                            @if($log->coach_note)
                                                <div class="alert alert-warning p-2 mb-0">
                                                    <small class="fw-bold"><i class="fas fa-comment-dots"></i>
                                                        {{ $log->coach->name ?? 'Coach' }}:</small>
                                                    <p class="mb-0 small fst-italic">"{{ $log->coach_note }}"</p>
                                                </div>
                                            @else
                                                <span class="text-muted small">- Belum ada feedback -</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('client.progress.show', $log->id) }}" class="btn btn-link btn-info" data-bs-toggle="tooltip" title="Lihat">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('client.progress.edit', $log->id) }}" class="btn btn-link btn-warning" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('client.progress.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada catatan progress. Yuk mulai catat!
                                        </td>
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