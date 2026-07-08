<x-app-layout>
    <x-slot name="header">Monitoring Progress Klien</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <div>
                        <h4 class="card-title fw-bold text-dark mb-0" style="font-size: 1.1rem;">Log Progress Terbaru Klien</h4>
                        <small class="text-muted">Pantau perkembangan ukuran fisik, konsumsi nutrisi, dan aktivitas latihan klien pendampingan Anda.</small>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TANGGAL LOG</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">NAMA KLIEN</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">TIPE LOG</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">RINGKASAN DATA</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px;">STATUS FEEDBACK</th>
                                    <th style="font-size: 0.72rem; letter-spacing: 0.08em; color: #8d94a5; font-weight: 700; text-transform: uppercase; padding: 12px 8px; text-align: center; width: 140px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    @php
                                        $nameParts = explode(' ', trim($log->client->name ?? 'N/A'));
                                        $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                                        $avatarBg = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'][$log->client->id % 8];
                                    @endphp
                                    <tr>
                                        <td style="padding: 12px 8px;">
                                            <span class="text-dark fw-bold" style="font-size: 0.88rem;">
                                                <i class="far fa-calendar-alt text-muted me-1.5" style="font-size: 0.85rem;"></i>
                                                {{ $log->date->translatedFormat('d M Y') }}
                                            </span>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            <div class="d-flex align-items-center">
                                                @if($log->client->avatar ?? false)
                                                    <img src="{{ asset('storage/' . $log->client->avatar) }}" class="rounded-circle me-2.5" style="width: 32px; height: 32px; object-fit: cover; border: 1.5px solid #5c55e344;">
                                                @else
                                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold me-2.5" style="width: 32px; height: 32px; font-size: 0.8rem; background: {{ $avatarBg }};">
                                                        {{ $initials }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $log->client->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($log->type == 'workout')
                                                <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(92, 85, 227, 0.08);">Workout</span>
                                            @elseif($log->type == 'nutrition')
                                                <span class="badge text-info" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(29, 122, 243, 0.08);">Nutrition</span>
                                            @else
                                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 700; border-radius: 30px; padding: 2px 8px; background-color: rgba(46, 204, 113, 0.08);">Body Check</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($log->weight)
                                                <div class="d-inline-block me-3">
                                                    <small class="text-muted">Berat:</small> <strong class="text-dark" style="font-size: 0.82rem;">{{ $log->weight }} kg</strong>
                                                </div>
                                            @endif
                                            @if($log->waist)
                                                <div class="d-inline-block">
                                                    <small class="text-muted">Pinggang:</small> <strong class="text-dark" style="font-size: 0.82rem;">{{ $log->waist }} cm</strong>
                                                </div>
                                            @endif
                                            @if(!$log->waist && !$log->weight)
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;">
                                            @if($log->coach_note)
                                                <span class="badge text-success" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(46, 204, 113, 0.08);">
                                                    <i class="fas fa-check-circle me-1"></i> Direview
                                                </span>
                                            @else
                                                <span class="badge text-warning" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(241, 196, 15, 0.08);">
                                                    <i class="fas fa-hourglass-half me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 8px;" class="text-center">
                                            <a href="{{ route('coach.progress.show', $log->id) }}" 
                                               class="btn btn-xs fw-semibold px-3 py-1.5" 
                                               style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;"
                                               onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" 
                                               onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                                <i class="fa fa-eye me-1"></i> Tinjau
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">Belum ada log progress dari klien Anda.</td>
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