<x-app-layout>
    <x-slot name="header">Detail Sesi Coaching</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Detail Rencana Sesi</h4>
                        <small class="text-muted">Informasi lengkap mengenai jadwal pertemuan bimbingan klien Anda.</small>
                    </div>
                    <a href="{{ route('coach.sessions.index') }}" class="btn btn-outline-secondary btn-round btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4 pt-2">
                    {{-- Client Profile Block --}}
                    <div class="d-flex align-items-center mb-4 p-3 rounded" style="background: rgba(0,0,0,0.02); border-radius: 10px;">
                        @php
                            $nameParts = explode(' ', trim($session->client->name ?? 'N/A'));
                            $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            $avatarBg = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'][$session->client->id % 8];
                        @endphp
                        @if($session->client->avatar ?? false)
                            <img src="{{ asset('storage/' . $session->client->avatar) }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #5c55e344;">
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold me-3" style="width: 50px; height: 50px; font-size: 1.1rem; background: {{ $avatarBg }};">
                                {{ $initials }}
                            </div>
                        @endif
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Klien Bimbingan</small>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $session->client->name }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $session->client->email }}</small>
                        </div>
                    </div>

                    {{-- Details List --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600;">JUDUL SESI</small>
                                <span class="text-dark fw-bold" style="font-size: 0.92rem;">{{ $session->title }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600;">JADWAL SESI</small>
                                <span class="text-dark fw-bold" style="font-size: 0.92rem;">
                                    <i class="far fa-calendar-alt text-primary me-1"></i> {{ $session->date->translatedFormat('d M Y') }}
                                    <span class="text-muted font-weight-normal ms-1">({{ $session->date->format('H:i') }} WIB)</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block mb-1.5" style="font-size: 0.7rem; font-weight: 600;">TIPE PERTEMUAN</small>
                                @if($session->type == 'online')
                                    <span class="badge text-primary" style="font-size: 0.7rem; font-weight: 700; border-radius: 30px; padding: 3px 10px; background-color: rgba(92, 85, 227, 0.08);">Online / Virtual</span>
                                @else
                                    <span class="badge text-success" style="font-size: 0.7rem; font-weight: 700; border-radius: 30px; padding: 3px 10px; background-color: rgba(46, 204, 113, 0.08);">Offline / Tatap Muka</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-light" style="background: #fafafa; border-radius: 8px;">
                                <small class="text-muted d-block mb-1.5" style="font-size: 0.7rem; font-weight: 600;">STATUS KEHADIRAN</small>
                                @if($session->date->isPast())
                                    <span class="badge text-success" style="font-size: 0.7rem; font-weight: 700; border-radius: 30px; padding: 3px 10px; background-color: rgba(46, 204, 113, 0.08);">Selesai Terlaksana</span>
                                @else
                                    <span class="badge text-primary" style="font-size: 0.7rem; font-weight: 700; border-radius: 30px; padding: 3px 10px; background-color: rgba(92, 85, 227, 0.08);">Terjadwal</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Meeting Notes / Link --}}
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="far fa-comment-alt me-1.5 text-primary"></i> Catatan Sesi & Link Meeting</h6>
                    @if($session->notes)
                        <div class="p-3 rounded border text-muted bg-light text-start mb-2" style="font-size: 0.85rem; line-height: 1.6; border-radius: 8px;">
                            {{ $session->notes }}
                        </div>
                        @if(filter_var($session->notes, FILTER_VALIDATE_URL))
                            <div class="mt-2.5">
                                <a href="{{ $session->notes }}" target="_blank" class="btn btn-sm btn-primary btn-round">
                                    <i class="fas fa-external-link-alt me-1"></i> Hubungkan Kelas Video
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-3 text-center text-muted border rounded" style="border-style: dashed !important; border-radius: 8px;">
                            Belum ada catatan atau link meeting yang disematkan untuk sesi ini.
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0 d-flex justify-content-end gap-2">
                    <a href="{{ route('coach.sessions.edit', $session->id) }}" 
                       class="btn btn-xs fw-semibold px-4 py-2" 
                       style="border-radius: 30px; background-color: rgba(241, 196, 15, 0.08); color: #f1c40f; border: none; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='rgba(241, 196, 15, 0.16)'" 
                       onmouseout="this.style.backgroundColor='rgba(241, 196, 15, 0.08)'">
                        Edit Jadwal
                    </a>
                    <form action="{{ route('coach.sessions.destroy', $session->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi bimbingan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-xs fw-semibold px-4 py-2" 
                                style="border-radius: 30px; background-color: rgba(231, 76, 60, 0.08); color: #e74c3c; border: none; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='rgba(231, 76, 60, 0.16)'" 
                                onmouseout="this.style.backgroundColor='rgba(231, 76, 60, 0.08)'">
                            Hapus Sesi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>