<x-app-layout>
    <x-slot name="header">Jadwal Coaching Saya</x-slot>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h3 class="fw-bold text-dark mb-1">Riwayat & Jadwal Sesi Pertemuan</h3>
                    <p class="text-muted text-xs mb-3">Pantau seluruh jadwal bimbingan aktif nutrisi dan fitness Anda bersama Coach terpilih.</p>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL & JAM</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">JUDUL SESI</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PELATIH (COACH)</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TIPE</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">CATATAN</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">STATUS</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr class="{{ $session->date->isPast() ? 'text-muted' : '' }}">
                                        <td style="white-space: nowrap;">
                                            <strong class="text-dark" style="font-size: 0.9rem;">{{ $session->date->format('d M Y') }}</strong> <br>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $session->date->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            <strong class="text-dark" style="font-size: 0.92rem;">{{ $session->title }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $session->coach->avatar ? asset('storage/' . $session->coach->avatar) : asset('kaiadmin/img/profile.jpg') }}" 
                                                     alt="{{ $session->coach->name }}" 
                                                     class="rounded-circle border me-2" 
                                                     style="width: 32px; height: 32px; object-fit: cover; border-color: #e2e8f0 !important;">
                                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $session->coach->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill {{ $session->type == 'online' ? 'bg-info' : 'bg-primary' }} text-white px-3 py-1 rounded-pill fw-bold" style="font-size: 10px;">
                                                {{ strtoupper($session->type) }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ Str::limit($session->notes, 40) ?: '-' }}</td>
                                        <td>
                                            @if($session->date->isPast())
                                                <span class="badge bg-secondary text-white px-3 py-1 rounded-pill fw-bold" style="font-size: 10px;">Selesai</span>
                                            @else
                                                <span class="badge bg-success text-white px-3 py-1 rounded-pill fw-bold" style="font-size: 10px;">Akan Datang</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('client.sessions.show', $session->id) }}"
                                                class="btn btn-sm btn-round btn-primary px-3 shadow-sm">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada jadwal sesi bimbingan saat ini.</td>
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