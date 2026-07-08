@forelse($coaches as $coach)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative coach-hover-card" style="transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 14px;">
            @php
                $isFitness = $coach->specialization == 'fitness';
                $formattedPhone = '';
                if ($coach->phone) {
                    $formattedPhone = preg_replace('/[^0-9]/', '', $coach->phone);
                    if (str_starts_with($formattedPhone, '0')) {
                        $formattedPhone = '62' . substr($formattedPhone, 1);
                    }
                }
            @endphp

            <!-- Header: Avatar as full background image -->
            <div class="position-relative" style="height: 170px;">
                @if($coach->avatar)
                    <img src="{{ asset('storage/' . $coach->avatar) }}" class="w-100 h-100" alt="{{ $coach->name }}" style="object-fit: cover;">
                    <!-- Dark gradient overlay so badges stay readable on any photo -->
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.45) 0%, transparent 40%, transparent 60%, rgba(0,0,0,0.25) 100%);"></div>
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: {{ $isFitness ? 'linear-gradient(135deg, #3b82f6, #1d4ed8)' : 'linear-gradient(135deg, #22c55e, #16a34a)' }};">
                        <i class="fas {{ $isFitness ? 'fa-dumbbell' : 'fa-apple-alt' }} text-white" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                @endif

                <!-- Status Badge (Top-Left) -->
                <span class="badge position-absolute top-0 start-0 m-2 fw-bold shadow" style="background-color: {{ $coach->is_active ? 'rgba(34,197,94,0.92)' : 'rgba(239,68,68,0.92)' }}; color: white; font-size: 0.6rem; padding: 4px 8px; border-radius: 6px; backdrop-filter: blur(4px);">
                    <i class="fas {{ $coach->is_active ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>{{ $coach->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>

                <!-- Specialization Badge (Top-Right) -->
                <span class="badge position-absolute top-0 end-0 m-2 fw-bold shadow" style="background: rgba(255,255,255,0.92); color: {{ $isFitness ? '#1d4ed8' : '#16a34a' }}; font-size: 0.6rem; padding: 4px 8px; border-radius: 6px; backdrop-filter: blur(4px);">
                    {{ $isFitness ? 'Fitness' : 'Nutritionist' }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body text-center d-flex flex-column py-3 px-3">
                <!-- Name & Email Container (fixed height for consistency) -->
                <div class="d-flex flex-column align-items-center justify-content-center mb-2" style="min-height: 55px;">
                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.88rem; line-height: 1.3;">
                        {{ $coach->name }}
                    </h6>
                    <p class="text-muted mb-0" style="font-size: 0.7rem;"><i class="far fa-envelope me-1"></i>{{ $coach->email }}</p>
                </div>

                <!-- Keahlian / Spesialisasi -->
                <div class="mb-3 px-1 text-start w-100">
                    <div style="font-size: 0.62rem; color: #888; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">Keahlian / Spesialisasi</div>
                    <div class="text-dark fw-bold" style="font-size: 0.76rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $coach->coachProfile?->specialization ?? 'Belum diatur' }}">
                        {{ $coach->coachProfile?->specialization ?: 'Belum diatur' }}
                    </div>
                </div>

                <!-- WA & Klien info (pushed to bottom) -->
                <div class="d-flex justify-content-around py-2 border-top mt-auto w-100">
                    <div class="text-center">
                        <span class="text-muted d-block" style="font-size: 0.6rem;">WhatsApp</span>
                        <strong style="font-size: 0.72rem;">
                            @if($coach->phone)
                                <a href="https://wa.me/{{ $formattedPhone }}" target="_blank" class="text-decoration-none text-dark" style="transition: color 0.15s ease;" onmouseover="this.style.color='#128c7e'" onmouseout="this.style.color='inherit'">
                                    <i class="fab fa-whatsapp text-success me-1"></i>{{ $coach->phone }}
                                </a>
                            @else
                                <span class="text-muted"><i class="fab fa-whatsapp me-1"></i>-</span>
                            @endif
                        </strong>
                    </div>
                    <div class="vr" style="opacity: 0.15;"></div>
                    <div class="text-center">
                        <span class="text-muted d-block" style="font-size: 0.6rem;">Klien Diampu</span>
                        <strong class="text-dark" style="font-size: 0.72rem;"><i class="fas fa-users text-primary me-1"></i>{{ $coach->clients_count }} Klien</strong>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer border-0 d-flex p-2 px-3 pb-3 gap-2" style="background: transparent;">
                <a href="{{ route('admin.coaches.show', $coach->id) }}" class="btn btn-sm btn-primary flex-grow-1 d-flex align-items-center justify-content-center" style="border-radius: 8px; font-size: 0.72rem; padding: 6px 0;">
                    <i class="fa fa-cogs me-1"></i> Atur Klien
                </a>
                <button type="button" class="btn btn-sm btn-outline-warning flex-grow-1 d-flex align-items-center justify-content-center btn-edit-coach"
                    style="border-radius: 8px; font-size: 0.72rem; padding: 6px 0;"
                    data-id="{{ $coach->id }}"
                    data-name="{{ $coach->name }}"
                    data-email="{{ $coach->email }}"
                    data-phone="{{ $coach->phone }}"
                    data-specialization="{{ $coach->specialization }}"
                    data-is-active="{{ $coach->is_active ? '1' : '0' }}"
                    data-avatar-url="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : '' }}"
                    data-expertise="{{ $coach->coachProfile?->specialization ?? '' }}"
                >
                    <i class="fa fa-edit me-1"></i> Edit Data
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <div class="card border-0 shadow-sm p-5" style="border-radius: 14px;">
            <i class="fas fa-users text-muted fa-3x mb-3"></i>
            <p class="text-muted mb-0">Belum ada data coach.</p>
        </div>
    </div>
@endforelse

<!-- Pagination Links -->
<div class="col-12">
    <div class="d-flex justify-content-center mt-4">
        {!! $coaches->links() !!}
    </div>
</div>
