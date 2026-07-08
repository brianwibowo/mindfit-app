@if($view === 'clients')
    {{-- View: Grouped by Client --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        @forelse($clients as $client)
            @php
                $latestLog = $client->progressLogs->first();
                $logCount  = $client->progressLogs->count();
                $reviewedCount = $client->progressLogs->whereNotNull('coach_note')->count();
                $pt = $client->coaches->where('specialization', 'fitness')->first();
                $nutritionist = $client->coaches->where('specialization', 'nutritionist')->first();

                // Generate initials for avatar fallback
                $nameParts = explode(' ', trim($client->name));
                $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

                // Consistent avatar background color based on client id
                $avatarColors = ['#5c55e3','#1d7af3','#f3545d','#2ecc71','#ff9f43','#48abf7','#6861ce','#31ce36'];
                $avatarBg = $avatarColors[$client->id % count($avatarColors)];
            @endphp
            <div class="col mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all position-relative" style="border-radius: 14px; overflow: hidden; background: var(--card-bg, #ffffff);">
                    {{-- Card Header: Premium Gradient Background --}}
                    <div class="position-relative" style="height: 90px; background: linear-gradient(135deg, {{ $avatarBg }}aa, {{ $avatarBg }});">
                        {{-- Log count badge (Top Right only, explicitly styled to prevent circular clipping) --}}
                        <span class="position-absolute" style="top: 12px; right: 12px; background: rgba(0, 0, 0, 0.6) !important; color: #fff !important; font-size: 11px !important; font-weight: 600 !important; padding: 4px 10px !important; border-radius: 30px !important; backdrop-filter: blur(4px); line-height: 1.2 !important; display: inline-block !important; width: auto !important; height: auto !important; white-space: nowrap !important; border: none !important;">
                            {{ $logCount }} Log
                        </span>
                    </div>

                    {{-- Card Avatar: Centered and half-offset over header --}}
                    <div class="text-center" style="margin-top: -40px; position: relative; z-index: 2;">
                        @if($client->avatar)
                            <img src="{{ asset('storage/' . $client->avatar) }}" class="rounded-circle shadow-sm border border-white border-3"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold shadow-sm border border-white border-3"
                                style="width: 80px; height: 80px; font-size: 1.6rem; background: {{ $avatarBg }}; box-shadow: 0 4px 10px {{ $avatarBg }}44;">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>

                    {{-- Client Info & Data --}}
                    <div class="card-body p-3 pt-2 text-center">
                        <h6 class="fw-bold mb-0 text-dark text-truncate" title="{{ $client->name }}" style="font-size: 0.95rem;">{{ $client->name }}</h6>
                        <p class="text-muted text-xs mb-2 text-truncate">{{ $client->email }}</p>

                        {{-- Update Timestamp (Centered, full card width, collision-proof) --}}
                        @if($latestLog)
                            <div class="mb-3">
                                <span class="badge bg-light text-muted border text-xxs px-2.5 py-1.5" style="font-size: 0.68rem; font-weight: 500; border-radius: 6px;">
                                    <i class="far fa-clock me-1 text-primary"></i> Update: {{ $latestLog->date->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        @endif

                        {{-- Coaches Badges --}}
                        <div class="mb-3 d-flex flex-wrap justify-content-center gap-1">
                            @if($pt)
                                <span class="badge text-primary text-xxs" style="font-size: 0.65rem; border-radius: 20px; padding: 4px 8px; background-color: rgba(29, 122, 243, 0.08);">
                                    <i class="fa fa-dumbbell me-1"></i> {{ $pt->name }}
                                </span>
                            @endif
                            @if($nutritionist)
                                <span class="badge text-success text-xxs" style="font-size: 0.65rem; border-radius: 20px; padding: 4px 8px; background-color: rgba(49, 206, 54, 0.08);">
                                    <i class="fa fa-apple-alt me-1"></i> {{ $nutritionist->name }}
                                </span>
                            @endif
                            @if(!$pt && !$nutritionist)
                                <span class="badge bg-light text-muted border text-xxs" style="font-size: 0.65rem; border-radius: 20px; padding: 4px 8px;">
                                    Belum ada Coach
                                </span>
                            @endif
                        </div>

                        {{-- Latest Physical Status --}}
                        @if($latestLog)
                            <div class="row text-center bg-light rounded py-2 g-0 mb-3" style="background: rgba(0,0,0,0.02) !important; border-radius: 8px;">
                                <div class="col-4 border-end">
                                    <span class="text-muted text-xxs d-block" style="font-size: 0.62rem; margin-bottom: 2px;">Berat</span>
                                    <strong class="text-dark" style="font-size: 0.8rem;">{{ $latestLog->weight ?? '-' }} kg</strong>
                                </div>
                                <div class="col-4 border-end">
                                    <span class="text-muted text-xxs d-block" style="font-size: 0.62rem; margin-bottom: 2px;">Pinggang</span>
                                    <strong class="text-dark" style="font-size: 0.8rem;">{{ $latestLog->waist ?? '-' }} cm</strong>
                                </div>
                                <div class="col-4">
                                    <span class="text-muted text-xxs d-block" style="font-size: 0.62rem; margin-bottom: 2px;">Tinggi</span>
                                    <strong class="text-dark" style="font-size: 0.8rem;">{{ $latestLog->height ?? '-' }} cm</strong>
                                </div>
                            </div>
                            
                            {{-- Premium Full-width Review Progress Indicator --}}
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                @if($reviewedCount === $logCount)
                                    <span class="badge w-100 py-2 border-0" 
                                          style="font-size: 0.72rem; border-radius: 8px; font-weight: 600; background-color: rgba(49, 206, 54, 0.08); color: #2ecc71;">
                                        <i class="fas fa-check-circle me-1.5"></i>
                                        {{ $reviewedCount }}/{{ $logCount }} Laporan Direview
                                    </span>
                                @else
                                    <span class="badge w-100 py-2 border-0" 
                                          style="font-size: 0.72rem; border-radius: 8px; font-weight: 600; background-color: rgba(255, 159, 67, 0.08); color: #ff9f43;">
                                        <i class="fas fa-clock me-1.5"></i>
                                        {{ $reviewedCount }}/{{ $logCount }} Laporan Direview
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 text-muted text-xs bg-light rounded mb-3" style="border-radius: 8px;">
                                Belum menginput ukuran fisik.
                            </div>
                        @endif
                    </div>

                    {{-- Action Button (No top border / lines!) --}}
                    <div class="card-footer p-3 bg-transparent border-0 pt-0" style="border-top: none !important; box-shadow: none !important;">
                        @if($logCount > 0)
                            <a href="{{ route('admin.progress.client_timeline', $client->id) }}" class="btn btn-primary btn-round btn-sm w-100 text-center">
                                <i class="fa fa-chart-line me-1"></i> Lihat Grafik & Riwayat
                            </a>
                        @else
                            <button class="btn btn-secondary btn-round btn-sm w-100" disabled>
                                <i class="fa fa-chart-line me-1"></i> Tidak ada data
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="fas fa-users-slash fa-3x mb-3"></i><br>
                <h5>Belum ada klien yang memiliki progress log.</h5>
            </div>
        @endforelse
    </div>

    <!-- Pagination for Clients Grid -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $clients->links('pagination::bootstrap-5') }}
    </div>

@else
    {{-- View: Recent Unreviewed Logs --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL INPUT</th>
                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">KLIEN</th>
                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TIPE LOG</th>
                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">DATA PROGRES</th>
                    <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; text-align: center; width: 150px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $log->date->translatedFormat('d M Y') }}</span><br>
                            <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $log->client->name ?? 'N/A' }}</span><br>
                            <small class="text-muted">{{ $log->client->email ?? '' }}</small>
                        </td>
                        <td>
                            @if($log->type == 'weight')
                                <span class="badge text-primary" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(92, 85, 227, 0.08);">Weight</span>
                            @else
                                <span class="badge text-info" style="font-size: 0.72rem; font-weight: 600; border-radius: 30px; padding: 4px 10px; background-color: rgba(29, 122, 243, 0.08);">Nutrition</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-3">
                                @if($log->weight)
                                    <div><small class="text-muted">Berat:</small> <span class="fw-bold text-dark">{{ $log->weight }} kg</span></div>
                                @endif
                                @if($log->waist)
                                    <div><small class="text-muted">Pinggang:</small> <span class="fw-bold text-dark">{{ $log->waist }} cm</span></div>
                                @endif
                                @php
                                    $tb = $log->height ?: ($log->client->clientProfile->height ?? null);
                                @endphp
                                @if($tb)
                                    <div><small class="text-muted">Tinggi:</small> <span class="fw-bold text-dark">{{ $tb }} cm</span></div>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.progress.show', $log->id) }}" class="btn btn-xs fw-semibold px-3 py-1.5" 
                               style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;"
                               onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" 
                               onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'">
                                <i class="fa fa-eye me-1"></i> Tinjau
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-check-circle fa-3x mb-2 text-success opacity-50"></i><br>
                            Semua progress log harian sudah direview oleh coach!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination for Recent Logs Table -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
@endif
