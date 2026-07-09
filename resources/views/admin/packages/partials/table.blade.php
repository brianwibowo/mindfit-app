<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
        <thead>
            <tr>
                <th style="width: 80px;">Cover</th>
                <th>Nama Paket</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Status</th>
                <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $package)
                <tr>
                    <td>
                        @php
                            $images = json_decode($package->image);
                            $validImage = null;
                            if (is_array($images) && count($images) > 0) {
                                $validImage = $images[0];
                            } elseif ($package->image && !is_array($images)) {
                                $validImage = $package->image;
                            }
                        @endphp

                        @if($validImage)
                            <div class="rounded shadow-sm overflow-hidden" style="width: 48px; height: 48px; border: 2px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.06) !important;">
                                <img src="{{ asset('storage/' . $validImage) }}" alt="img" width="100%" height="100%" style="object-fit: cover;">
                            </div>
                        @else
                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded border" style="width: 48px; height: 48px;">
                                <i class="fas fa-image" style="font-size: 1.1rem; opacity: 0.35;"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $package->name }}</span>
                    </td>
                    <td>
                        @if($package->type == 'fitness')
                            <span class="badge text-primary" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(29, 122, 243, 0.08);">
                                <i class="fa fa-dumbbell me-1"></i> Fitness
                            </span>
                        @else
                            <span class="badge text-success" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(49, 206, 54, 0.08);">
                                <i class="fa fa-apple-alt me-1"></i> Nutritionist
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold text-dark" style="font-size: 0.9rem; color: #2c3e50 !important;">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">{{ $package->duration_days }} Hari</span>
                    </td>
                    <td>
                        @if($package->is_active)
                            <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #2ecc71; vertical-align: middle; margin-top: -2px;"></span>
                                Aktif
                            </span>
                        @else
                            <span class="badge" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 5px 12px; background-color: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #e74c3c; vertical-align: middle; margin-top: -2px;"></span>
                                Non-Aktif
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs fw-semibold px-3 py-1.5" style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;" onclick="viewPackageDetail({{ $package->id }})" onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                            <i class="fas fa-eye me-1"></i> Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2 opacity-50"></i><br>
                        Belum ada paket tersedia untuk kategori ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    {!! $packages->links('pagination::bootstrap-5') !!}
</div>
