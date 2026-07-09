<x-app-layout>
    <x-slot name="header">Monitoring Analisa AI</x-slot>

    <!-- Custom CSS for Premium Design Elements -->
    <style>
        .table thead th {
            font-size: 0.72rem !important;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 700;
            color: #8d94a5;
            border-bottom-width: 1px !important;
            background-color: rgba(0, 0, 0, 0.01) !important;
            padding: 14px 16px !important;
        }
        .table tbody td {
            padding: 14px 16px !important;
            vertical-align: middle;
        }
        .hover-shadow {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05) !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header pb-3 bg-white" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 24px;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Daftar Analisa Kebutuhan User</h4>
                            <p class="text-muted text-xs mb-0">Lihat riwayat hasil kalkulasi kesehatan BMR/TDEE dan saran program dari asisten AI.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.ai.create') }}" class="btn btn-primary btn-round btn-sm px-3.5 py-2 fw-semibold">
                                <i class="fas fa-plus me-1.5"></i> Buat Analisa Baru
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Paket Rekomendasi</th>
                                    <th>Target</th>
                                    <th>Risiko Medis</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analyses as $item)
                                    <tr>
                                        <td>
                                            <span class="text-dark fw-semibold" style="font-size: 0.85rem;">
                                                {{ $item->created_at->format('d M Y') }}
                                            </span><br>
                                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $item->name }}</span><br>
                                            <small class="text-muted">{{ $item->user->email ?? 'Guest / Tamu' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge text-primary" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 12px; background-color: rgba(29, 122, 243, 0.08);">
                                                <i class="fas fa-box me-1"></i> {{ $item->recommendation_package }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">{{ $item->target }}</span>
                                        </td>
                                        <td>
                                            @if(stripos($item->health_history, 'tidak ada') === false && stripos($item->health_history, 'aman') === false)
                                                <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                                    <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #e74c3c; vertical-align: middle; margin-top: -2px;"></span>
                                                    Ada Riwayat
                                                </span>
                                            @else
                                                <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                                                    <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #2ecc71; vertical-align: middle; margin-top: -2px;"></span>
                                                    Sehat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.ai.show', $item->id) }}" class="btn btn-xs fw-semibold px-3 py-1.5" style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s; display: inline-block;" onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-brain fa-2x mb-2 opacity-50"></i><br>
                                            Belum ada data analisa kebutuhan user.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $analyses->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>