<x-app-layout>
    <x-slot name="header">Dashboard Coach {{ ucfirst(Auth::user()->specialization) }}</x-slot>

    <div class="row mb-1">
        {{-- Stats Cards --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center text-primary bubble-shadow-small" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background-color: rgba(92, 85, 227, 0.1); display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="font-size: 1.3rem; color: #5c55e3;"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3">
                            <div class="numbers">
                                <p class="card-category text-muted mb-1" style="font-size: 0.8rem; font-weight: 500;">Klien Aktif</p>
                                <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.5rem;">{{ $clients->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <div>
                        <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Daftar Klien Saya</h4>
                        <small class="text-muted">Daftar klien aktif yang saat ini Anda pandu untuk bimbingan kesehatan.</small>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px; width: 60px;">#</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">NAMA KLIEN</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">EMAIL & KONTAK</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TIPE BIMBINGAN</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px; width: 140px; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $index => $client)
                                    @php
                                        $nameParts = explode(' ', trim($client->name ?? 'N/A'));
                                        $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                                        $avatarBg = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'][$client->id % 8];
                                    @endphp
                                    <tr>
                                        <td style="padding: 12px 8px;" class="fw-semibold text-muted">{{ $index + 1 }}</td>
                                        <td style="padding: 12px 8px;">
                                            <div class="d-flex align-items-center">
                                                @if($client->avatar ?? false)
                                                    <img src="{{ asset('storage/' . $client->avatar) }}" class="rounded-circle me-2.5" style="width: 36px; height: 36px; object-fit: cover; border: 1.5px solid #5c55e344;">
                                                @else
                                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold me-2.5" style="width: 36px; height: 36px; font-size: 0.85rem; background: {{ $avatarBg }};">
                                                        {{ $initials }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $client->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-dark fw-semibold" style="font-size: 0.85rem;">{{ $client->email }}</span><br>
                                            <small class="text-muted" style="font-size: 0.72rem; font-weight: 500;">
                                                <i class="fas fa-phone-alt me-1 text-muted" style="font-size: 0.68rem;"></i>
                                                {{ $client->phone ?? '-' }}
                                            </small>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($client->pivot->type == 'fitness')
                                                <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(92, 85, 227, 0.08);">Fitness / Olahraga</span>
                                            @else
                                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(46, 204, 113, 0.08);">Nutritionist / Diet</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;" class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-xs fw-semibold px-3 py-1.5 dropdown-toggle border-0" 
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; transition: all 0.2s;"
                                                        onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" 
                                                        onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                                    Pilihan
                                                </button>
                                                <ul class="dropdown-menu border-0 shadow-sm py-2 mt-1" style="border-radius: 10px; font-size: 0.82rem;">
                                                    <li>
                                                        <a class="dropdown-item py-2 px-3 text-dark"
                                                            href="{{ route('coach.sessions.create', $client->id) }}">
                                                            <i class="fas fa-calendar-plus text-primary me-2" style="width: 14px;"></i> Jadwalkan Sesi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item py-2 px-3 text-dark" href="{{ route('coach.progress.index') }}">
                                                            <i class="fas fa-chart-line text-success me-2" style="width: 14px;"></i> Lihat Progress Klien
                                                        </a>
                                                    </li>
                                                    @if($client->phone)
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 text-dark" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->phone) }}" target="_blank">
                                                                <i class="fab fa-whatsapp text-success me-2" style="width: 14px;"></i> Chat WhatsApp
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">Belum ada klien yang ditugaskan kepada Anda.</td>
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