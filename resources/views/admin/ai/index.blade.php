<x-app-layout>
    <x-slot name="header">Monitoring Analisa AI</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Analisa Kebutuhan User</h4>
                        <a href="{{ route('admin.ai.create') }}" class="btn btn-primary btn-sm btn-round">
                            <i class="fas fa-plus me-1"></i> Buat Analisa Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Paket Rekomendasi</th>
                                    <th>Target</th>
                                    <th>Risiko Medis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analyses as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->user->email ?? 'Guest' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->recommendation_package }}</span>
                                        </td>
                                        <td>{{ $item->target }}</td>
                                        <td>
                                            @if(stripos($item->health_history, 'tidak ada') === false)
                                                <span class="badge bg-warning text-dark">Ada Riwayat</span>
                                            @else
                                                <span class="badge bg-success">Sehat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.ai.show', $item->id) }}"
                                                class="btn btn-icon btn-round btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $analyses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>