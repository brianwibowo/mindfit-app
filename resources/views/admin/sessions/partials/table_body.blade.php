<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="min-width: 850px;">
        <thead>
            <tr>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">TANGGAL</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">WAKTU</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">SESI</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">PELATIH (COACH)</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5;">KLIEN</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; width: 15%;">STATUS SESI</th>
                <th style="font-size: 0.75rem; letter-spacing: 0.08em; color: #8d94a5; width: 15%; text-align: center;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
                <tr data-session-id="{{ $session->id }}">
                    <td>
                        <span class="text-dark fw-bold" style="font-size: 0.88rem;">
                            <i class="far fa-calendar-alt text-muted me-1.5" style="font-size: 0.85rem;"></i>
                            {{ $session->date->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">
                            <i class="far fa-clock text-muted me-1.5" style="font-size: 0.85rem;"></i>
                            {{ $session->date->format('H:i') }} WIB
                        </span>
                    </td>
                    <td>
                        <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $session->title }}</span><br>
                        @if($session->type == 'online')
                            <span class="badge text-primary" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(92, 85, 227, 0.08);">Online</span>
                        @else
                            <span class="badge text-success" style="font-size: 0.68rem; font-weight: 600; border-radius: 30px; padding: 3px 8px; background-color: rgba(46, 204, 113, 0.08);">Offline</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $session->coach->name ?? '-' }}</span><br>
                        <small class="text-muted" style="font-size: 0.72rem; font-weight: 500;">
                            {{ ucfirst($session->coach->specialization ?? '') }}
                        </small>
                    </td>
                    <td>
                        <span class="text-dark fw-bold" style="font-size: 0.88rem;">{{ $session->client->name ?? '-' }}</span><br>
                        <small class="text-muted" style="font-size: 0.72rem; font-weight: 500;">
                            {{ $session->client->email ?? '' }}
                        </small>
                    </td>
                    <td>
                        <!-- Inline Status Switcher -->
                        <div class="d-flex align-items-center gap-1">
                            <select class="form-select form-control form-control-sm quick-status-select py-1 px-2.5" 
                                    data-id="{{ $session->id }}" 
                                    style="border-radius: 20px; font-size: 0.78rem; font-weight: 700; width: 125px; border: none; cursor: pointer; transition: all 0.2s;
                                           background-color: {{ $session->status == 'scheduled' ? '#e8f0fe' : ($session->status == 'completed' ? '#e6f4ea' : '#fce8e6') }};
                                           color: {{ $session->status == 'scheduled' ? '#1a73e8' : ($session->status == 'completed' ? '#137333' : '#c5221f') }};">
                                <option value="scheduled" {{ $session->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ $session->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $session->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <!-- Inline Spinner Element -->
                            <span class="status-spinner spinner-border spinner-border-sm text-primary d-none" role="status" style="width: 0.85rem; height: 0.85rem;"></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs fw-semibold px-3 py-1.5 btn-detail-session" 
                                data-id="{{ $session->id }}"
                                style="border-radius: 30px; background-color: rgba(92, 85, 227, 0.08); color: #5c55e3; border: none; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='rgba(92, 85, 227, 0.16)'" 
                                onmouseout="this.style.backgroundColor='rgba(92, 85, 227, 0.08)'"
                                title="Lihat Rincian Sesi">
                            <i class="fa fa-eye me-1"></i> Lihat
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-2 opacity-50"></i><br>
                            Belum ada jadwal sesi untuk filter kategori ini.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $sessions->links('pagination::bootstrap-5') }}
</div>
