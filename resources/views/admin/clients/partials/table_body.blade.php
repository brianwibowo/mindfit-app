<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TGL DAFTAR</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">KLIEN</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PAKET</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">BERAKHIR</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TOTAL</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">STATUS</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $p)
                <tr class="align-middle">
                    <td>
                        <span class="fw-semibold text-dark">{{ $p->created_at->format('d M Y') }}</span><br>
                        <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                        <small class="text-muted">{{ $p->user->email }}</small>
                    </td>
                    <td class="text-dark" style="max-width: 250px;">
                        <span class="fw-semibold">{{ $p->package_data['package_name'] ?? '-' }}</span>
                    </td>
                    <td>
                        @if($p->user->is_premium && $p->user->premium_until)
                            <span class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($p->user->premium_until)->format('d M Y') }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="fw-bold text-dark">
                        Rp {{ number_format($p->package_data['total_price'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <span class="badge-soft-{{ $p->status == 'approved' ? 'success' : ($p->status == 'pending' ? 'warning' : ($p->status == 'rejected' ? 'danger' : 'info')) }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            @if($p->proof_file)
                                <button type="button" class="btn btn-info btn-premium-action btn-preview-proof" 
                                        data-proof="{{ asset('storage/' . $p->proof_file) }}" 
                                        data-client="{{ $p->user->name }}">
                                    <i class="fa fa-image"></i> Bukti
                                </button>
                            @endif
                            <a href="{{ route('admin.verification.show', $p->id) }}" class="btn btn-primary btn-premium-action">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                            Tidak ada data pendaftaran dengan status ini.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $payments->links('pagination::bootstrap-5') }}
</div>
