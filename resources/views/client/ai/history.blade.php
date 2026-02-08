<x-app-layout>
    <x-slot name="header">Riwayat Analisa AI</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-round">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Riwayat Analisa Kebutuhan</h4>
                        <a href="{{ route('client.ai.index') }}" class="btn btn-primary btn-round">
                            <i class="fas fa-plus me-2"></i> Analisa Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($analyses->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada riwayat analisa.</p>
                            <a href="{{ route('client.ai.index') }}" class="btn btn-outline-primary btn-sm">Mulai Analisa
                                Sekarang</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Paket Rekomendasi</th>
                                        <th>Target</th>
                                        <th>BMI / Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($analyses as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="fw-bold text-primary">{{ $item->recommendation_package }}</span>
                                            </td>
                                            <td>{{ $item->target }}</td>
                                            <td>
                                                {{ $item->bmi_score }}
                                                <small class="text-muted">({{ $item->bmi_status }})</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('client.ai.show', $item->id) }}"
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>