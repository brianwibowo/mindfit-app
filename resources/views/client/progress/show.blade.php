<x-app-layout>
    <x-slot name="header">Detail Progress</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="card-title">Detail Log Progress</div>
                        <div>
                            <a href="{{ route('client.progress.pdf', $log->id) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                            </a>
                            <a href="{{ route('client.progress.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $log->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Log</th>
                                    <td><span class="badge badge-info">{{ ucfirst($log->type) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Berat Badan</th>
                                    <td>{{ $log->weight ? $log->weight . ' Kg' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lingkar Pinggang</th>
                                    <td>{{ $log->waist ? $log->waist . ' cm' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tinggi Badan</th>
                                    <td>{{ $log->height ? $log->height . ' cm' : '-' }}</td>
                                </tr>
                            </table>
                            <hr>

                            <h6>Catatan Anda:</h6>
                            <p class="text-muted fst-italic">
                                "{{ $log->description ?: 'Tidak ada catatan.' }}"
                            </p>

                            @if($log->coach_note)
                                <div class="alert alert-warning mt-3">
                                    <h6><i class="fas fa-comment-dots"></i> Catatan Coach
                                        ({{ $log->coach->name ?? 'Coach' }}):</h6>
                                    <p class="mb-0">"{{ $log->coach_note }}"</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 text-center">
                            @if($log->photo)
                                <h6>Foto Kondisi Fisik</h6>
                                <img src="{{ asset('storage/' . $log->photo) }}" class="img-fluid rounded border mb-2"
                                    style="max-height: 300px;">
                                <br>
                                <a href="{{ asset('storage/' . $log->photo) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-search-plus"></i> Lihat Full Size
                                </a>
                            @else
                                <div class="alert alert-light">
                                    <i class="fas fa-camera-retro fa-2x mb-3 text-muted"></i>
                                    <p class="text-muted">Tidak ada foto dilampirkan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('client.progress.edit', $log->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('client.progress.destroy', $log->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus log ini?');">
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