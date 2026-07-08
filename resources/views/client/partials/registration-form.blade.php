@php
    $isEdit = isset($payment);
    $actionUrl = $isEdit ? route('client.payment.update', $payment->id) : route('client.payment.store');
    $currentPackageId = $isEdit ? $payment->package_id : null;
    $hasMealPlan = $isEdit ? ($payment->package_data['addon_meal_plan'] ?? false) : false;
@endphp

<style>
    /* Stepper Styling */
    .step-indicator {
        cursor: pointer;
    }
    .step-number {
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        width: 40px !important;
        height: 40px !important;
        font-size: 1.1rem;
    }
    .step-indicator.active .step-number {
        background-color: #1572E8 !important;
        color: white !important;
        border-color: #1572E8 !important;
        box-shadow: 0 0 0 3px rgba(21, 114, 232, 0.2);
    }
    .step-indicator.active .step-label {
        color: #1572E8 !important;
        font-weight: 700 !important;
        font-size: 12px !important;
    }
    .step-indicator.completed .step-number {
        background-color: #28a745 !important;
        color: white !important;
        border-color: #28a745 !important;
    }
    .step-indicator.completed .step-label {
        color: #28a745 !important;
        font-weight: 700 !important;
        font-size: 12px !important;
    }
    .step-label {
        font-size: 12px !important;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .step-connector {
        transition: all 0.3s ease;
    }
    .step-connector.active {
        border-color: #1572E8 !important;
    }
    .step-connector.completed {
        border-color: #28a745 !important;
    }

    /* Coach Card Styling */
    .coach-card {
        border-width: 2px !important;
        transition: all 0.2s ease-in-out;
        position: relative;
    }
    .coach-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .coach-card.border-primary {
        border-color: #1572E8 !important;
        background-color: #f0f6ff !important;
    }
    .coach-card.border-success {
        border-color: #28a745 !important;
        background-color: #f0fff4 !important;
    }

    /* Selected Coach Indicator Checkmark */
    .coach-selected-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #1572E8;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        z-index: 10;
    }
    .coach-card.border-primary .coach-selected-badge,
    .coach-card.border-success .coach-selected-badge {
        display: flex !important;
    }

    /* Coupon validation visual cues */
    .coupon-success {
        border-color: #28a745 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    .coupon-danger {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='M7.8 4.2L4.2 7.8M4.2 4.2l3.6 3.6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .shake {
        animation: shake 0.2s ease-in-out 0s 2;
    }

    /* Drag & Drop Zone */
    #drop-zone:hover {
        background-color: #f8fafc !important;
        border-color: #1572E8 !important;
    }
    #drop-zone.dragover {
        background-color: #eff6ff !important;
        border-color: #1572E8 !important;
    }

    /* Package Row Clickable & Accessible Spacing */
    .package-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
        padding: 0.95rem 1rem !important; /* V9: Accessible size */
        min-height: 48px;
    }
    .package-row:hover {
        background-color: #f0f6ff !important;
    }
    .package-row.selected {
        background-color: #e8f0fe !important;
        border-left: 4px solid #1572E8 !important;
    }

    /* Toast custom styling */
    .toast-mindfit {
        border-left: 4px solid #ff9800;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    }

    /* Toast progress bar animation classes */
    .toast-progress-bar {
        width: 100%;
        background-color: #28a745;
        height: 100%;
    }
    .toast-progress-active {
        width: 0% !important;
        transition: width 3s linear !important;
    }
    #toastProgressContainer {
        height: 4px;
        background-color: rgba(0,0,0,0.05) !important;
        border-radius: 0;
        margin-top: -4px;
        overflow: hidden;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    /* Monospace Bank Account numbers */
    .bank-number {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        letter-spacing: 0.5px;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    /* Responsive Mobile Sticky Bottom Checkout Summary */
    .mobile-checkout-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #ffffff;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        padding: 12px 16px;
        z-index: 1040;
        border-top: 1px solid #e2e8f0;
        display: none;
    }
    @media (max-width: 991.98px) {
        .mobile-checkout-bar {
            display: block;
        }
        body {
            padding-bottom: 75px; /* Give room for sticky bottom */
        }
    }
</style>

<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; max-width: 350px; width: 100%;">
    <div id="validationToast" class="toast fade toast-mindfit bg-white w-100 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-dark">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong class="me-auto">Perhatian</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody" style="font-size: 0.9rem; padding: 12px;">
        </div>
        <div id="toastProgressContainer" style="height: 3px; background-color: rgba(0,0,0,0.05); overflow: hidden; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; display: none; margin-top: -2px;">
            <div id="toastProgress" class="toast-progress-bar"></div>
        </div>
    </div>
</div>

<!-- Visual Stepper Progress Bar -->
<div class="card mb-4 border shadow-sm">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center px-md-4">
            <div class="step-indicator active text-center flex-fill" id="step-tab-1" data-step="1">
                <div class="step-number bg-white text-muted rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1">1</div>
                <div class="step-label text-muted d-block small">Data Diri</div>
            </div>
            <div class="step-connector flex-fill border-top border-2 mx-2 mb-3 border-light" id="step-conn-1" style="margin-top: -12px;"></div>
            <div class="step-indicator text-center flex-fill" id="step-tab-2" data-step="2">
                <div class="step-number bg-white text-muted rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1">2</div>
                <div class="step-label text-muted d-block small">Paket & Coach</div>
            </div>
            <div class="step-connector flex-fill border-top border-2 mx-2 mb-3 border-light" id="step-conn-2" style="margin-top: -12px;"></div>
            <div class="step-indicator text-center flex-fill" id="step-tab-3" data-step="3">
                <div class="step-number bg-white text-muted rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1">3</div>
                <div class="step-label text-muted d-block small">Pembayaran</div>
            </div>
        </div>
    </div>
</div>

<!-- C1: Server-Side validation errors alert box -->
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-1"></i> Gagal Menyimpan! Harap periksa input Anda:</h6>
        <ul class="mb-0 ps-3" style="font-size: 13px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Main Form Column (Left) -->
    <div class="col-lg-8 mb-4">
        <div class="card border shadow-sm mb-0">
            <div class="card-body">
                <form id="paymentForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($isEdit)
                        @method('PATCH')
                    @endif

                    {{-- STEP 1: DATA DIRI --}}
                    <div id="step-1" class="setup-content">
                        <h5 class="text-primary fw-bold mb-3"><i class="fas fa-user-circle me-1"></i> 1. Informasi Data Diri</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Email</label>
                                    <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required placeholder="Contoh: 08123456789">
                                    <div class="text-danger small d-none mt-1" id="phone-feedback">Nomor WhatsApp wajib diisi dengan format yang benar (dimulai dengan 08, 10-15 digit).</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Alamat Domisili <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}" required placeholder="Jl. ...">
                                    <div class="text-danger small d-none mt-1" id="address-feedback">Alamat domisili wajib diisi!</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary px-4 btn-next-step">
                                Lanjut ke Paket & Coach <i class="fas fa-chevron-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    {{-- STEP 2: PILIH PAKET & COACH --}}
                    <div id="step-2" class="setup-content" style="display:none;">
                        <h5 class="text-primary fw-bold mb-3"><i class="fas fa-box-open me-1"></i> 2. Pilihan Paket Keanggotaan <span class="text-muted small fw-normal">(bisa pilih lebih dari satu)</span></h5>
                        @php
                            $selectedPackageIds = [];
                            if (old('package_ids')) {
                                $selectedPackageIds = old('package_ids');
                            } elseif (isset($payment) && isset($payment->package_data['package_ids'])) {
                                $selectedPackageIds = $payment->package_data['package_ids'];
                            } elseif (isset($payment) && $payment->package_id) {
                                $selectedPackageIds = [$payment->package_id];
                            }

                            $categories = [
                                'Private Class' => [],
                                'Squad (Group)' => [],
                                'Academy (Team)' => [],
                                'Nutritionist' => [],
                                'Lainnya' => []
                            ];
                            
                            foreach($packages as $p) {
                                if (str_contains($p->name, '[Private]')) $categories['Private Class'][] = $p;
                                elseif (str_contains($p->name, '[Group]')) $categories['Squad (Group)'][] = $p;
                                elseif (str_contains($p->name, '[Academy]')) $categories['Academy (Team)'][] = $p;
                                elseif (str_contains($p->name, '[Nutrition]')) $categories['Nutritionist'][] = $p;
                                else $categories['Lainnya'][] = $p;
                            }
                        @endphp

                        <div id="packageAccordion" class="mb-4">
                            @foreach($categories as $catName => $items)
                                @if(count($items) > 0)
                                    <div class="card mb-2 border shadow-none">
                                        <div class="card-header p-2 bg-light" id="heading{{ Str::slug($catName) }}" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($catName) }}">
                                            <h6 class="mb-0 text-primary fw-bold">
                                                <i class="fas fa-chevron-right me-2 small"></i> {{ $catName }}
                                            </h6>
                                        </div>

                                        <div id="collapse{{ Str::slug($catName) }}" class="collapse show">
                                            <div class="card-body p-2">
                                                @foreach($items as $pkg)
                                                    <div class="form-check p-2 border-bottom d-flex align-items-center justify-content-between package-row" data-pkg-id="{{ $pkg->id }}">
                                                        <div>
                                                            <input class="form-check-input package-checkbox" type="checkbox" 
                                                                name="package_ids[]" 
                                                                id="pkg{{ $pkg->id }}" 
                                                                value="{{ $pkg->id }}"
                                                                data-name="{{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name) }}"
                                                                data-price="{{ $pkg->price }}"
                                                                {{ in_array($pkg->id, $selectedPackageIds) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold ms-2" for="pkg{{ $pkg->id }}">
                                                                {{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name) }}
                                                            </label>
                                                            <div class="small text-muted ms-4">
                                                                Rp {{ number_format($pkg->price, 0, ',', '.') }} 
                                                                <span class="badge bg-secondary ms-1">{{ $pkg->duration_days }} Hari</span>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-xs btn-outline-info rounded-circle btn-pkg-info" 
                                                            onclick="event.stopPropagation(); showPackageDetails('{{ $pkg->name }}', `{{ $pkg->description }}`)">
                                                            <i class="fas fa-info" style="font-size: 10px;"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="text-danger small d-none mt-2" id="package-feedback">Anda wajib memilih salah satu paket untuk melanjutkan!</div>
                        </div>

                        <!-- Pilihan Coach PT & Nutritionist -->
                        <hr class="my-4">
                        <h5 class="text-primary fw-bold mb-3"><i class="fas fa-user-friends me-1"></i> Pilihan Personal Trainer (PT) & Nutritionist</h5>
                        <div class="row">
                            <!-- PT Column -->
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold mb-2">Pilih Personal Trainer (PT) <span class="text-danger">*</span></label>
                                <div class="row row-cols-1 g-2" id="ptList">
                                    @foreach($coaches->where('specialization', 'fitness') as $coach)
                                        <div class="col">
                                            <div class="card p-2 border coach-card shadow-sm mb-0 cursor-pointer" data-coach-id="{{ $coach->id }}" style="cursor: pointer;">
                                                <div class="coach-selected-badge"><i class="fas fa-check"></i></div>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}" alt="{{ $coach->name }}" class="rounded-circle border" style="width: 46px; height: 46px; object-fit: cover;">
                                                    <div class="ms-3 flex-grow-1">
                                                        <div class="d-flex align-items-center">
                                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $coach->name }}</h6>
                                                            <i class="fas fa-info-circle text-info ms-2 btn-coach-info" 
                                                               style="cursor: pointer; font-size: 1rem;" 
                                                               data-coach-name="{{ $coach->name }}" 
                                                               data-coach-role="Personal Trainer"
                                                                data-coach-expertise="{{ $coach->coachProfile?->specialization ?? '' }}"
                                                               data-coach-avatar="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}"></i>
                                                        </div>
                                                        <span class="badge bg-primary text-white" style="font-size: 10px; padding: 3px 8px;">Personal Trainer</span>
                                                    </div>
                                                    <div class="form-check me-1">
                                                        <input class="form-check-input coach-radio" type="radio" name="selected_pt_id" value="{{ $coach->id }}" data-name="{{ $coach->name }}" id="coach_pt_{{ $coach->id }}" {{ (old('selected_pt_id') == $coach->id || (isset($payment) && isset($payment->package_data['pt_id']) && $payment->package_data['pt_id'] == $coach->id)) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-danger small d-none mt-2" id="pt-feedback">Anda wajib memilih salah satu Personal Trainer!</div>
                            </div>

                            <!-- Nutritionist Column -->
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold mb-2">Pilih Nutritionist <span class="text-muted small">(Jika pilih paket Nutritionist)</span></label>
                                <div class="row row-cols-1 g-2" id="nutriList">
                                    @foreach($coaches->where('specialization', 'nutritionist') as $coach)
                                        <div class="col">
                                            <div class="card p-2 border coach-card shadow-sm mb-0 cursor-pointer" data-coach-id="{{ $coach->id }}" style="cursor: pointer;">
                                                <div class="coach-selected-badge"><i class="fas fa-check"></i></div>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}" alt="{{ $coach->name }}" class="rounded-circle border" style="width: 46px; height: 46px; object-fit: cover;">
                                                    <div class="ms-3 flex-grow-1">
                                                        <div class="d-flex align-items-center">
                                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $coach->name }}</h6>
                                                            <i class="fas fa-info-circle text-info ms-2 btn-coach-info" 
                                                                style="cursor: pointer; font-size: 1rem;" 
                                                                data-coach-name="{{ $coach->name }}" 
                                                                data-coach-role="Nutritionist"
                                                                data-coach-expertise="{{ $coach->coachProfile?->specialization ?? '' }}"
                                                                data-coach-avatar="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}"></i>
                                                        </div>
                                                        <span class="badge bg-success text-white" style="font-size: 10px; padding: 3px 8px;">Nutritionist</span>
                                                    </div>
                                                    <div class="form-check me-1">
                                                        <input class="form-check-input coach-radio" type="radio" name="selected_nutritionist_id" value="{{ $coach->id }}" data-name="{{ $coach->name }}" id="coach_nutri_{{ $coach->id }}" {{ (old('selected_nutritionist_id') == $coach->id || (isset($payment) && isset($payment->package_data['nutritionist_id']) && $payment->package_data['nutritionist_id'] == $coach->id)) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 btn-prev-step">
                                <i class="fas fa-chevron-left me-1"></i> Kembali ke Data Diri
                            </button>
                            <button type="button" class="btn btn-primary px-4 btn-next-step">
                                Lanjut ke Pembayaran <i class="fas fa-chevron-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    {{-- STEP 3: PEMBAYARAN & KONFIRMASI --}}
                    <div id="step-3" class="setup-content" style="display:none;">
                        <h5 class="text-primary fw-bold mb-3"><i class="fas fa-wallet me-1"></i> 3. Petunjuk Transfer & Pembayaran</h5>
                        
                        <div class="p-3 bg-light mb-4 rounded border text-dark">
                            <h6 class="fw-bold mb-2 text-primary">Transfer Bank (a.n RIO SETIOBUDI):</h6>
                            <ul class="list-unstyled mb-3 ms-2 text-dark" style="font-size: 13.5px; line-height: 1.8;">
                                <li class="mb-1">
                                    <span class="fw-bold" style="width: 140px; display: inline-block;">Bank BRI</span> : 
                                    <span class="bank-number">682001024177536</span>
                                    <button type="button" class="btn btn-xs btn-link text-decoration-none px-2 py-0 ms-1 btn-copy-rekening" data-num="682001024177536"><i class="far fa-copy"></i> Salin</button>
                                </li>
                                <li class="mb-1">
                                    <span class="fw-bold" style="width: 140px; display: inline-block;">Bank BSI</span> : 
                                    <span class="bank-number">7294376733</span>
                                    <button type="button" class="btn btn-xs btn-link text-decoration-none px-2 py-0 ms-1 btn-copy-rekening" data-num="7294376733"><i class="far fa-copy"></i> Salin</button>
                                </li>
                                <li class="mb-1">
                                    <span class="fw-bold" style="width: 140px; display: inline-block;">Jago Syariah</span> : 
                                    <span class="bank-number">508542930068</span>
                                    <button type="button" class="btn btn-xs btn-link text-decoration-none px-2 py-0 ms-1 btn-copy-rekening" data-num="508542930068"><i class="far fa-copy"></i> Salin</button>
                                </li>
                            </ul>
                            
                            <h6 class="fw-bold mb-2 text-primary">E-Wallet:</h6>
                            <ul class="list-unstyled mb-0 ms-2 text-dark" style="font-size: 13.5px; line-height: 1.8;">
                                <li class="mb-1">
                                    <span class="fw-bold" style="width: 140px; display: inline-block;">Shopee Pay</span> : 
                                    <span class="bank-number">085642501572</span>
                                    <button type="button" class="btn btn-xs btn-link text-decoration-none px-2 py-0 ms-1 btn-copy-rekening" data-num="085642501572"><i class="far fa-copy"></i> Salin</button>
                                </li>
                                <li class="mb-1">
                                    <span class="fw-bold" style="width: 140px; display: inline-block;">GO-PAY</span> : 
                                    <span class="bank-number">085869155931</span>
                                    <button type="button" class="btn btn-xs btn-link text-decoration-none px-2 py-0 ms-1 btn-copy-rekening" data-num="085869155931"><i class="far fa-copy"></i> Salin</button>
                                </li>
                            </ul>
                            <hr class="my-2">
                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Konfirmasi manual hubungi Admin: <a href="https://wa.me/6285199615786?text=Halo%20Admin%20MindFit%2C%20saya%20ingin%20melakukan%20konfirmasi%20pembayaran.%20Terima%20kasih!" target="_blank" class="fw-bold text-success"><i class="fab fa-whatsapp"></i> 0851-9961-5786 (WhatsApp)</a></small>
                        </div>

                        <!-- KODE DISKON -->
                        <div class="form-group mb-4 px-0">
                            <label for="discount_code" class="fw-bold">Gunakan Voucher / Kode Diskon <span class="text-muted">(Opsional)</span></label>
                            <div class="input-group" style="max-width: 420px;">
                                <input type="text" name="discount_code" id="discount_code" class="form-control" value="{{ old('discount_code', isset($payment) ? ($payment->package_data['discount_code'] ?? '') : '') }}" placeholder="Contoh: PROMO50, MINDFIT10">
                                <button class="btn btn-primary d-flex align-items-center" type="button" id="btnApplyDiscount">
                                    <span id="discountBtnText">Terapkan</span>
                                    <span id="discountSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                            <small class="text-success d-none mt-1 fw-bold" id="discountMessage"><i class="fas fa-check-circle"></i> Kode berhasil diterapkan! Diskon <span id="discountPercentage">0</span>%</small>
                            <small class="text-danger d-none mt-1 fw-bold" id="discountErrorMessage"><i class="fas fa-times-circle"></i> Kode diskon tidak valid.</small>
                        </div>

                        <!-- UPLOAD BUKTI TRANSFER DRAG & DROP -->
                        <div class="form-group mb-4 px-0">
                            <label class="fw-bold">Upload Bukti Pembayaran <span class="text-danger">{{ $isEdit ? '' : '*' }}</span></label>
                            
                            <div id="drop-zone" class="border border-2 border-dashed rounded p-4 text-center cursor-pointer mb-2 bg-light d-flex flex-column align-items-center justify-content-center" 
                                 style="border-color: #cbd5e0 !important; min-height: 150px; transition: all 0.2s;">
                                <input type="file" name="proof_file" id="proof_file" class="d-none" accept="image/*,application/pdf,.heic,.heif" {{ $isEdit ? '' : 'required' }}>
                                
                                <div id="upload-prompt">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                    <p class="mb-1 fw-bold text-dark" style="font-size: 0.9rem;">Tarik & lepaskan bukti transfer di sini, atau klik untuk memilih file</p>
                                    <span class="text-muted small">Format: JPG, PNG, PDF, HEIC, HEIF (Maksimal 5MB)</span>
                                </div>
                                
                                <div id="file-preview-container" class="d-none w-100">
                                    <img id="file-image-preview" src="#" alt="Preview" class="img-fluid rounded border mb-2 d-none" style="max-height: 180px; object-fit: contain;">
                                    <div id="file-pdf-preview" class="d-none p-3 bg-white rounded border mb-2 align-items-center justify-content-center gap-2 mx-auto" style="max-width: 320px;">
                                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                        <span id="file-pdf-name" class="fw-bold small text-truncate text-dark" style="max-width: 220px;">receipt.pdf</span>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-xs btn-outline-danger" id="btnRemoveFile">
                                        <i class="fas fa-trash-alt me-1"></i> Ganti Berkas
                                    </button>
                                </div>
                            </div>
                            <div class="text-danger small d-none mt-1" id="proof-feedback">Bukti transfer wajib diunggah!</div>
                            
                            @if($isEdit && $payment->proof_file)
                                <div class="mt-2" id="current-proof-block">
                                    <small class="text-muted d-block mb-1">Bukti Terunggah Saat Ini:</small>
                                    <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $payment->proof_file) }}" height="90" class="rounded border">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- SYARAT & KETENTUAN -->
                        <div class="form-check mb-4">
                            <label class="form-check-label" style="cursor: pointer;">
                                <input class="form-check-input" type="checkbox" id="terms_agree" required>
                                <span class="form-check-sign fw-bold text-dark" style="font-size: 13.5px;">Saya menyetujui syarat & ketentuan pendaftaran yang berlaku di MindFit. <span class="text-danger">*</span></span>
                            </label>
                            <div class="text-danger small d-none mt-1" id="terms-feedback" style="margin-left: 20px;">Anda wajib menyetujui syarat & ketentuan!</div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 btn-prev-step">
                                <i class="fas fa-chevron-left me-1"></i> Kembali ke Layanan
                            </button>
                            <button type="submit" class="btn btn-success px-4" id="btnSubmitForm">
                                <i class="fas fa-check-circle me-1"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Kirim Pendaftaran' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sticky Checkout Summary Column (Right) -->
    <div class="col-lg-4 d-none d-lg-block" id="desktop-sidebar">
        <div class="card border shadow-sm sticky-top" style="top: 80px; z-index: 99;">
            <div class="card-header bg-primary text-white p-3">
                <h5 class="card-title text-white mb-0" style="font-size: 0.95rem; font-weight: 700;"><i class="fas fa-shopping-cart me-2"></i> Ringkasan Belanja</h5>
            </div>
            <div class="card-body p-3 text-dark">
                <!-- Package Detail Row -->
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">PAKET LAYANAN</span>
                    <div id="summary-pkg-name" class="fw-bold text-dark" style="font-size: 0.95rem;">- Belum Memilih -</div>
                    <div id="summary-pkg-price" class="text-muted small">Rp 0</div>
                </div>

                <!-- PT Detail Row -->
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">PERSONAL TRAINER (PT)</span>
                    <div id="summary-pt-name" class="text-muted small" style="font-weight: 500;">Belum Memilih</div>
                </div>

                <!-- Nutritionist Detail Row -->
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">NUTRITIONIST</span>
                    <div id="summary-nutri-name" class="text-muted small" style="font-weight: 500;">Belum Memilih</div>
                </div>

                <!-- Voucher Discount Row -->
                <div class="mb-3 border-bottom pb-2 d-none" id="summary-discount-row">
                    <span class="text-success fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">DISKON / KUPON VOUCHER</span>
                    <div id="summary-discount-code" class="fw-bold text-success" style="font-size: 0.9rem;">-</div>
                    <div id="summary-discount-amount" class="text-success small">-Rp 0</div>
                </div>

                <!-- Total Payment Row -->
                <div class="mb-4 p-3 bg-light rounded text-center border">
                    <span class="text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">TOTAL PEMBAYARAN</span>
                    <div id="summary-total-tagihan" class="text-primary fw-bold" style="font-size: 1.4rem;">Rp 0</div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAILS PAKET --}}
<div class="modal fade" id="packageDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="pkgModalTitle">Detail Paket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark" id="pkgModalBody">
                <!-- Content -->
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL BIO COACH --}}
<div class="modal fade" id="coachDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-info-circle me-1"></i> Detail Profil Pelatih</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-b
            ody text-dark py-4 text-center">
                <img id="coachModalAvatar" src="" class="rounded-circle border mb-3 shadow" style="width: 100px; height: 100px; object-fit: cover;">
                <h4 id="coachModalName" class="fw-bold mb-1 text-dark">Coach Name</h4>
                <span id="coachModalRole" class="badge bg-secondary mb-3">Role</span>
                
                <div class="p-3 bg-light rounded text-start border mt-2">
                    <h6 class="fw-bold mb-1 text-muted" style="font-size: 11px;">KEAHLIAN / SPESIALISASI:</h6>
                    <p id="coachModalExpertise" class="mb-0 text-dark fw-bold small"></p>
                </div>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pendaftaran Final -->
<div class="modal fade text-dark" id="submitConfirmModal" tabindex="-1" aria-labelledby="submitConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title text-white fw-bold" id="submitConfirmModalLabel">
                    <i class="fas fa-check-circle me-2"></i> Konfirmasi Pendaftaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-file-invoice-dollar fa-4x text-success mb-3"></i>
                <h4 class="fw-bold mb-2 text-dark">Kirim Pendaftaran Anda?</h4>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">
                    Pastikan nominal bukti transfer Anda sudah sesuai dengan total pembayaran sebesar:
                    <strong class="d-block text-primary fs-4 mt-2" id="confirm-total-price">Rp 0</strong>
                </p>
                <div class="alert alert-info text-start small mb-0 border-0 shadow-sm" style="background-color: #f0f6ff;">
                    <i class="fas fa-info-circle me-1 text-primary"></i> 
                    Pendaftaran Anda akan ditinjau oleh tim admin dalam waktu maksimal 24 jam setelah pengiriman.
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top d-flex justify-content-between">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Periksa Kembali</button>
                <button type="button" class="btn btn-success px-4" id="btnConfirmSubmit">
                    Ya, Kirim Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            // IndexedDB Helper to persist File object across page refreshes
            var dbName = "MindFitRegDB";
            var storeName = "files";

            function openDB(callback) {
                var request = indexedDB.open(dbName, 1);
                request.onupgradeneeded = function(e) {
                    var db = e.target.result;
                    if (!db.objectStoreNames.contains(storeName)) {
                        db.createObjectStore(storeName);
                    }
                };
                request.onsuccess = function(e) {
                    callback(e.target.result);
                };
            }

            function saveFileToDB(file) {
                openDB(function(db) {
                    var tx = db.transaction(storeName, "readwrite");
                    var store = tx.objectStore(storeName);
                    store.put(file, "proof_file");
                });
            }

            function getFileFromDB(callback) {
                openDB(function(db) {
                    var tx = db.transaction(storeName, "readonly");
                    var store = tx.objectStore(storeName);
                    var request = store.get("proof_file");
                    request.onsuccess = function(e) {
                        callback(e.target.result);
                    };
                    request.onerror = function() {
                        callback(null);
                    };
                });
            }

            function clearFileFromDB() {
                openDB(function(db) {
                    var tx = db.transaction(storeName, "readwrite");
                    var store = tx.objectStore(storeName);
                    store.delete("proof_file");
                });
            }

            // Track Step
            var currentStep = 1;

            // Track Selections
            var activePackageIds = [];
            $('input[name="package_ids[]"]:checked').each(function() {
                activePackageIds.push($(this).val());
            });
            var activePtId = $('input[name="selected_pt_id"]:checked').val() || null;
            var activeNutriId = $('input[name="selected_nutritionist_id"]:checked').val() || null;

            // Voucher/Discount Data
            var discountPercent = 0;
            var discountAmount = 0;
            var appliedCode = "";

            function goToStep(step) {
                if (step < 1 || step > 3) return;

                // Validate transition
                if (step > currentStep) {
                    if (currentStep === 1 && !validateStep1()) {
                        scrollToFirstError();
                        return;
                    }
                    if (currentStep === 2 && !validateStep2()) {
                        scrollToFirstError();
                        return;
                    }
                }

                // Transition forms
                $('#step-' + currentStep).hide();
                $('#step-' + step).show();

                // Update Progress Tabs & Connectors
                updateProgressIndicators(step);

                currentStep = step;

                saveFormState();
            }

            function updateProgressIndicators(step) {
                // Reset Indicators
                $('.step-indicator').removeClass('active completed');
                $('.step-connector').removeClass('active completed');

                // Apply completed to previous steps
                for (var i = 1; i < step; i++) {
                    $('#step-tab-' + i).addClass('completed');
                    $('#step-conn-' + i).addClass('completed');
                }

                // Apply active to current step
                $('#step-tab-' + step).addClass('active');
            }

            // Real-Time WA Phone Number Format Check (08xxx format, 10-15 digits)
            function validatePhoneFormat() {
                var phoneVal = $('#phone').val().trim();
                var phoneRegex = /^08[0-9]{8,13}$/;
                
                if (phoneVal === "") {
                    $('#phone').addClass('is-invalid');
                    $('#phone-feedback').text('Nomor WhatsApp wajib diisi!').removeClass('d-none');
                    return false;
                } else if (!phoneRegex.test(phoneVal)) {
                    $('#phone').addClass('is-invalid');
                    $('#phone-feedback').text('Format nomor WhatsApp tidak valid. Gunakan format 08xxx (10-15 digit).').removeClass('d-none');
                    return false;
                } else {
                    $('#phone').removeClass('is-invalid').addClass('is-valid');
                    $('#phone-feedback').addClass('d-none');
                    return true;
                }
            }

            $('#phone').on('blur input', function() {
                validatePhoneFormat();
                saveFormState();
            });

            // Real-Time Alamat Domisili Check
            $('#address').on('blur input', function() {
                var addressVal = $(this).val().trim();
                if (addressVal !== "") {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $('#address-feedback').addClass('d-none');
                } else {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                    $('#address-feedback').removeClass('d-none');
                }
                saveFormState();
            });

            function validateStep1() {
                var phoneValid = validatePhoneFormat();
                var addressVal = $('#address').val().trim();
                var isValid = phoneValid;

                if (addressVal === "") {
                    $('#address').addClass('is-invalid');
                    $('#address-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#address').removeClass('is-invalid').addClass('is-valid');
                    $('#address-feedback').addClass('d-none');
                }

                return isValid;
            }

            function scrollToFirstError() {
                setTimeout(function() {
                    var $firstError = $('.is-invalid, .invalid-feedback:not(.d-none)').first();
                    if ($firstError.length) {
                        $firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            }

            function showToast(message, type = 'warning') {
                $('#toastBody').html(message);
                var $toastHeader = $('#validationToast .toast-header');
                var $toastIcon = $toastHeader.find('i');
                var $toastTitle = $toastHeader.find('strong');
                var $progressBar = $('#toastProgress');
                var $progressContainer = $('#toastProgressContainer');
                var toastEl = document.getElementById('validationToast');
                var delayTime = (type === 'success') ? 3000 : 8000;

                // Unbind old events to prevent multiple listeners
                $('#validationToast').off('hidden.bs.toast');

                if (type === 'success') {
                    $toastHeader.removeClass('bg-warning text-dark').addClass('bg-success text-white');
                    $toastIcon.removeClass('fa-exclamation-triangle text-dark').addClass('fa-check-circle text-white');
                    $toastTitle.html('👤 Info');
                    $('#validationToast').css('border-left', '4px solid #28a745');
                    
                    // Setup progress bar animation
                    $progressContainer.show();
                    $progressBar.removeClass('toast-progress-active').css('width', '100%');
                    
                    // Force browser reflow to register initial 100% width
                    toastEl.offsetHeight; 
                    
                    // Start progress bar animation
                    $progressBar.addClass('toast-progress-active');

                    // Reset progress bar after hide
                    $('#validationToast').on('hidden.bs.toast', function() {
                        $progressContainer.hide();
                        $progressBar.removeClass('toast-progress-active').css('width', '100%');
                    });
                } else {
                    $toastHeader.removeClass('bg-success text-white').addClass('bg-warning text-dark');
                    $toastIcon.removeClass('fa-check-circle text-white').addClass('fa-exclamation-triangle text-dark');
                    $toastTitle.text('Perhatian');
                    $('#validationToast').css('border-left', '4px solid #ff9800');
                    
                    $progressContainer.hide();
                }

                // Dispose existing bootstrap instance to apply new options (delay time)
                if (window.bootstrap && bootstrap.Toast) {
                    var existing = bootstrap.Toast.getInstance(toastEl);
                    if (existing) {
                        existing.dispose();
                    }
                    var bsToast = new bootstrap.Toast(toastEl, { delay: delayTime, animation: true });
                    bsToast.show();
                } else if ($.fn.toast) {
                    $(toastEl).toast('dispose').toast({ delay: delayTime, animation: true }).toast('show');
                }
            }

            function validateStep2() {
                var isValid = true;
                var messages = [];
                
                if (activePackageIds.length === 0) {
                    $('#package-feedback').removeClass('d-none');
                    $('#packageAccordion').addClass('shake');
                    setTimeout(function() {
                        $('#packageAccordion').removeClass('shake');
                    }, 500);
                    messages.push('📦 <b>Anda belum memilih paket apapun.</b>');
                    isValid = false;
                } else {
                    $('#package-feedback').addClass('d-none');
                }

                if (!activePtId) {
                    $('#pt-feedback').removeClass('d-none');
                    $('#ptList').addClass('shake');
                    setTimeout(function() {
                        $('#ptList').removeClass('shake');
                    }, 500);
                    messages.push('🏋️ <b>Anda belum memilih Personal Trainer.</b>');
                    isValid = false;
                } else {
                    $('#pt-feedback').addClass('d-none');
                }

                if (!isValid) {
                    var toastHtml = messages.join('<br>') + 
                        '<hr class="my-2">' +
                        '<small class="text-muted">Belum yakin memilih paket? Gunakan <a href="' + '{{ route("client.ai.index") }}' + '" class="fw-bold text-primary">Fitur AI</a> untuk rekomendasi, atau ' +
                        '<a href="https://wa.me/6285199615786?text=Halo%20Admin%20MindFit%2C%20saya%20ingin%20konsultasi%20mengenai%20paket%20yang%20cocok%20untuk%20saya.%20Terima%20kasih!" target="_blank" class="fw-bold text-success"><i class="fab fa-whatsapp"></i> chat Admin</a> untuk konsultasi paket.</small>';
                    showToast(toastHtml);
                }

                return isValid;
            }

            // Stepper Event Bindings
            $('.btn-next-step').on('click', function () {
                goToStep(currentStep + 1);
            });

            $('.btn-prev-step').on('click', function () {
                goToStep(currentStep - 1);
            });

            // Clickable stepper bar (only navigation backward is allowed to prevent skipping validation)
            $('.step-indicator').on('click', function() {
                var targetStep = parseInt($(this).data('step'));
                if (targetStep < currentStep) {
                    goToStep(targetStep);
                } else if (targetStep > currentStep) {
                    // Try to move forward if valid
                    goToStep(targetStep);
                }
            });

            // Copy Bank Account Clipboard Functionality
            $('.btn-copy-rekening').on('click', function(e) {
                e.preventDefault();
                var accountNum = $(this).data('num');
                
                // Copy to Clipboard
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(accountNum).select();
                document.execCommand("copy");
                $temp.remove();

                // Highlight copy success
                var $btn = $(this);
                var originalText = $btn.html();
                $btn.html('<i class="fas fa-check text-success"></i> Disalin').addClass('text-success');
                setTimeout(function() {
                    $btn.html(originalText).removeClass('text-success');
                }, 2000);
            });

            // Final Submit with Modal Confirmation and Double Submit Prevention
            var formSubmitted = false;
            $('#paymentForm').on('submit', function (e) {
                e.preventDefault(); // Stop default submit

                if (currentStep < 3) {
                    goToStep(3);
                } else {
                    // Final validation check for step 3
                    var isValid = true;
                    
                    // Check proof file if required
                    var isEditMode = {{ $isEdit ? 'true' : 'false' }};
                    var hasProofInput = $('#proof_file')[0].files.length > 0;
                    if (!isEditMode && !hasProofInput) {
                        $('#proof-feedback').removeClass('d-none');
                        $('#drop-zone').addClass('border-danger shake');
                        setTimeout(function() {
                            $('#drop-zone').removeClass('shake');
                        }, 500);
                        isValid = false;
                    } else {
                        $('#proof-feedback').addClass('d-none');
                        $('#drop-zone').removeClass('border-danger');
                    }

                    // Check terms agree
                    if (!$('#terms_agree').is(':checked')) {
                        $('#terms-feedback').removeClass('d-none');
                        isValid = false;
                    } else {
                        $('#terms-feedback').addClass('d-none');
                    }

                    if (!isValid) {
                        showToast('⚠️ <b>Harap lengkapi bukti transfer & setujui Syarat Ketentuan sebelum mengirim!</b>', 'warning');
                        scrollToFirstError();
                        return false;
                    }

                    // Validation passed -> Show Final Confirmation Modal
                    var totalHtml = $('#summary-total-tagihan').html();
                    $('#confirm-total-price').html(totalHtml);

                    var confirmModal = new bootstrap.Modal(document.getElementById('submitConfirmModal'));
                    confirmModal.show();
                }
            });

            // Trigger submit on confirmation confirm
            $('#btnConfirmSubmit').on('click', function() {
                if (formSubmitted) return; // Prevent double submit
                formSubmitted = true;
                
                // Show loading spinner
                $(this).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...').prop('disabled', true);
                $('#btnSubmitForm').prop('disabled', true);
                
                // Submit Form
                $('#paymentForm')[0].submit();
            });


            // --- COACH BIO DETAILS POPUP EVENT ---
            $(document).on('click', '.btn-coach-info', function (e) {
                e.stopPropagation(); // Avoid selecting the coach card when clicking info icon

                var name = $(this).data('coach-name');
                var role = $(this).data('coach-role');
                var avatar = $(this).data('coach-avatar');
                var expertise = $(this).data('coach-expertise');

                $('#coachModalAvatar').attr('src', avatar);
                $('#coachModalName').text(name);
                $('#coachModalRole').text(role);
                $('#coachModalExpertise').text(expertise || 'Belum diatur');

                var myModal = new bootstrap.Modal(document.getElementById('coachDetailModal'));
                myModal.show();
            });


            // --- DRAG & DROP RECIEPT HANDLER ---
            var $dropZone = $('#drop-zone');
            var $fileInput = $('#proof_file');

            $dropZone.on('click', function () {
                $fileInput.click();
            });

            $fileInput.on('click', function (e) {
                e.stopPropagation();
            });

            $dropZone.on('dragover', function (e) {
                e.preventDefault();
                $dropZone.addClass('dragover');
            });

            $dropZone.on('dragleave drop', function () {
                $dropZone.removeClass('dragover');
            });

            $dropZone.on('drop', function (e) {
                e.preventDefault();
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $fileInput[0].files = files;
                    handleFileSelected(files[0]);
                }
            });

            $fileInput.on('change', function () {
                if (this.files.length > 0) {
                    handleFileSelected(this.files[0]);
                }
            });

            function handleFileSelected(file, shouldSaveToDB = true) {
                $('#upload-prompt').addClass('d-none');
                $('#file-preview-container').removeClass('d-none');
                $('#proof-feedback').addClass('d-none');
                $('#drop-zone').removeClass('border-danger');

                // Save to IndexedDB
                if (shouldSaveToDB) {
                    saveFileToDB(file);
                }

                // Check File Type
                if (file.type.startsWith('image/')) {
                    // Image Preview
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#file-image-preview').attr('src', e.target.result).removeClass('d-none');
                        $('#file-pdf-preview').addClass('d-none');
                    }
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    // PDF Icon display
                    $('#file-pdf-name').text(file.name);
                    $('#file-pdf-preview').removeClass('d-none').addClass('d-flex');
                    $('#file-image-preview').addClass('d-none');
                } else {
                    // Generic preview
                    $('#file-pdf-name').text(file.name);
                    $('#file-pdf-preview').removeClass('d-none').addClass('d-flex');
                    $('#file-image-preview').addClass('d-none');
                }
            }

            $('#btnRemoveFile').on('click', function (e) {
                e.stopPropagation(); // Avoid triggering drop-zone click event
                
                // Clear input file
                $fileInput.val('');
                clearFileFromDB();
                
                // Reset display
                $('#upload-prompt').removeClass('d-none');
                $('#file-preview-container').addClass('d-none');
                $('#file-image-preview').attr('src', '#').addClass('d-none');
                $('#file-pdf-preview').removeClass('d-flex').addClass('d-none');
            });


            // --- COACH SELECT INTERACTION WITH DESELECT ---
            $(document).on('click', '.coach-card', function (e) {
                // If they clicked the info icon, let that event execute separately
                if ($(e.target).hasClass('btn-coach-info') || $(e.target).parent().hasClass('btn-coach-info')) {
                    return;
                }

                var $radio = $(this).find('input.coach-radio');
                var name = $radio.attr('name');
                var val = $radio.val();
                var coachName = $radio.data('name');

                if (name === 'selected_pt_id') {
                    if (activePtId === val) {
                        // Deselect PT
                        $radio.prop('checked', false).trigger('change');
                        activePtId = null;
                        $('#summary-pt-name').text('Tidak Memilih').addClass('text-muted').removeClass('text-dark fw-bold');
                        $('#mobile-summary-pt-name').text('Tidak Memilih').addClass('text-muted').removeClass('text-dark fw-bold');
                    } else {
                        // Select PT
                        $radio.prop('checked', true).trigger('change');
                        activePtId = val;
                        $('#summary-pt-name').text(coachName).removeClass('text-muted').addClass('text-dark fw-bold');
                        $('#mobile-summary-pt-name').text(coachName).removeClass('text-muted').addClass('text-dark fw-bold');
                    }
                } else if (name === 'selected_nutritionist_id') {
                    if (activeNutriId === val) {
                        // Deselect Nutritionist
                        $radio.prop('checked', false).trigger('change');
                        activeNutriId = null;
                        $('#summary-nutri-name').text('Tidak Memilih').addClass('text-muted').removeClass('text-dark fw-bold');
                        $('#mobile-summary-nutri-name').text('Tidak Memilih').addClass('text-muted').removeClass('text-dark fw-bold');
                    } else {
                        // Select Nutritionist
                        $radio.prop('checked', true).trigger('change');
                        activeNutriId = val;
                        $('#summary-nutri-name').text(coachName).removeClass('text-muted').addClass('text-dark fw-bold');
                        $('#mobile-summary-nutri-name').text(coachName).removeClass('text-muted').addClass('text-dark fw-bold');
                    }
                }
                saveFormState();
            });

            // Handle styling of cards based on radio change
            $(document).on('change', 'input.coach-radio', function () {
                var $radio = $(this);
                var name = $radio.attr('name');

                $('input[name="' + name + '"]').each(function() {
                    var $c = $(this).closest('.coach-card');
                    $c.removeClass('border-primary border-success bg-light');
                });

                $('input[name="' + name + '"]:checked').each(function() {
                    var $r = $(this);
                    var $c = $r.closest('.coach-card');
                    var isFitness = $r.attr('name') === 'selected_pt_id';
                    if (isFitness) {
                        $c.addClass('border-primary bg-light');
                    } else {
                        $c.addClass('border-success bg-light');
                    }
                });
            });


            // --- PACKAGE SELECT INTERACTION (MULTI-SELECT CHECKBOX) ---
            function togglePackageSelection($checkbox, forceState) {
                var isChecked = (typeof forceState !== 'undefined') ? forceState : !$checkbox.prop('checked');
                $checkbox.prop('checked', isChecked);

                var val = $checkbox.val();
                if (isChecked) {
                    $checkbox.closest('.package-row').addClass('selected');
                    if (activePackageIds.indexOf(val) === -1) {
                        activePackageIds.push(val);
                    }
                } else {
                    $checkbox.closest('.package-row').removeClass('selected');
                    var index = activePackageIds.indexOf(val);
                    if (index !== -1) {
                        activePackageIds.splice(index, 1);
                    }
                }

                // Hide package warning if visible
                if (activePackageIds.length > 0) {
                    $('#package-feedback').addClass('d-none');
                }

                updateSelectedPackagesUI();
                saveFormState();
            }

            function updateSelectedPackagesUI() {
                var names = [];
                var totalPrice = 0;

                $('input[name="package_ids[]"]').each(function() {
                    if ($(this).prop('checked')) {
                        names.push($(this).data('name'));
                        totalPrice += parseInt($(this).data('price')) || 0;
                    }
                });

                if (names.length > 0) {
                    $('#summary-pkg-name').text(names.join(' + ')).removeClass('text-muted').addClass('text-dark fw-bold');
                    $('#summary-pkg-price').text('Rp ' + totalPrice.toLocaleString('id-ID'));
                    $('#mobile-summary-pkg-name').text(names.join(' + ')).removeClass('text-muted').addClass('text-dark fw-bold');
                    $('#mobile-summary-pkg-price').text('Rp ' + totalPrice.toLocaleString('id-ID'));
                } else {
                    $('#summary-pkg-name').text('- Belum Memilih -').removeClass('text-dark fw-bold').addClass('text-muted');
                    $('#summary-pkg-price').text('Rp 0');
                    $('#mobile-summary-pkg-name').text('- Belum Memilih -').removeClass('text-dark fw-bold').addClass('text-muted');
                    $('#mobile-summary-pkg-price').text('Rp 0');
                }

                // Re-apply discount if there is a code entered
                var code = $('#discount_code').val();
                if (code && code.trim() !== '') {
                    applyDiscountCode(code);
                } else {
                    updateTotal();
                }
            }

            // Click on checkbox directly
            $(document).on('click', 'input[name="package_ids[]"]', function (e) {
                var isChecked = $(this).prop('checked');
                $(this).prop('checked', !isChecked);
                togglePackageSelection($(this), isChecked);
            });

            // Click on the whole row
            $(document).on('click', '.package-row', function (e) {
                if ($(e.target).closest('.btn-pkg-info').length > 0) return;
                if ($(e.target).is('input[name="package_ids[]"]')) return;

                var $checkbox = $(this).find('input[name="package_ids[]"]');
                togglePackageSelection($checkbox);
            });


            // --- VOUCHER & DISCOUNT CODE HANDLER ---
            function applyDiscountCode(code) {
                $('#discountMessage').addClass('d-none');
                $('#discountErrorMessage').addClass('d-none');
                $('#discount_code').removeClass('coupon-success coupon-danger shake');

                if (code.trim() === "") {
                    discountPercent = 0;
                    discountAmount = 0;
                    appliedCode = "";
                    $('#summary-discount-row').addClass('d-none');
                    $('#mobile-summary-discount-row').addClass('d-none');
                    updateTotal();
                    return;
                }

                if (activePackageIds.length === 0) {
                    $('#discountErrorMessage').text('Silakan pilih paket terlebih dahulu.').removeClass('d-none');
                    $('#discount_code').addClass('coupon-danger shake');
                    setTimeout(function() {
                        $('#discount_code').removeClass('shake');
                    }, 500);
                    updateTotal();
                    return;
                }

                // Show Loading Spinner state for applying discount
                $('#discountSpinner').removeClass('d-none');
                $('#discountBtnText').text('Memvalidasi...');
                $('#btnApplyDiscount').prop('disabled', true);

                $.ajax({
                    url: '{{ route("client.discount.validate") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                        package_ids: activePackageIds
                    },
                    success: function(response) {
                        // Reset Spinner State
                        $('#discountSpinner').addClass('d-none');
                        $('#discountBtnText').text('Terapkan');
                        $('#btnApplyDiscount').prop('disabled', false);

                        if (response.valid) {
                            discountPercent = response.percent;
                            discountAmount = response.discount_amount;
                            appliedCode = code.toUpperCase();
                            
                            // Visual success cues
                            $('#discountPercentage').text(discountPercent);
                            $('#discountMessage').removeClass('d-none');
                            $('#discount_code').addClass('coupon-success');

                            // Sidebar update
                            $('#summary-discount-code').text(appliedCode + ' (' + discountPercent + '%)');
                            $('#summary-discount-amount').text('-Rp ' + discountAmount.toLocaleString('id-ID'));
                            $('#summary-discount-row').removeClass('d-none');

                            // Mobile Sidebar update
                            $('#mobile-summary-discount-code').text(appliedCode + ' (' + discountPercent + '%)');
                            $('#mobile-summary-discount-amount').text('-Rp ' + discountAmount.toLocaleString('id-ID'));
                            $('#mobile-summary-discount-row').removeClass('d-none');

                            updateTotal();
                        } else {
                            discountPercent = 0;
                            discountAmount = 0;
                            appliedCode = "";
                            
                            // Visual failure cues
                            $('#discountErrorMessage').text(response.message).removeClass('d-none');
                            $('#discount_code').addClass('coupon-danger shake');
                            setTimeout(function() {
                                $('#discount_code').removeClass('shake');
                    }, 500);
                            $('#summary-discount-row').addClass('d-none');
                            $('#mobile-summary-discount-row').addClass('d-none');
                            updateTotal();
                        }
                    },
                    error: function() {
                        // Reset Spinner State
                        $('#discountSpinner').addClass('d-none');
                        $('#discountBtnText').text('Terapkan');
                        $('#btnApplyDiscount').prop('disabled', false);

                        discountPercent = 0;
                        discountAmount = 0;
                        appliedCode = "";
                        $('#discountErrorMessage').text('Gagal memvalidasi kode voucher.').removeClass('d-none');
                        $('#discount_code').addClass('coupon-danger shake');
                        setTimeout(function() {
                            $('#discount_code').removeClass('shake');
                        }, 500);
                        $('#summary-discount-row').addClass('d-none');
                        $('#mobile-summary-discount-row').addClass('d-none');
                        updateTotal();
                    }
                });
            }

            $('#btnApplyDiscount').on('click', function() {
                var code = $('#discount_code').val();
                applyDiscountCode(code);
            });


            // --- TOTAL TAGIHAN CALCULATOR ---
            function updateTotal() {
                var pkgPrice = 0;
                $('input[name="package_ids[]"]:checked').each(function() {
                    pkgPrice += parseInt($(this).data('price')) || 0;
                });

                var finalPrice = pkgPrice - discountAmount;

                // Update main alert inside Step 3 (total tagihan card fallback)
                if (discountPercent > 0) {
                    var totalHtml = '<del class="text-muted" style="font-size: 0.85rem; font-weight: normal;">Rp ' + pkgPrice.toLocaleString('id-ID') + '</del> ' +
                        '<br><span class="text-primary fw-bold" style="font-size: 1.4rem;">Rp ' + finalPrice.toLocaleString('id-ID') + '</span>';
                    $('#summary-total-tagihan').html(totalHtml);
                    $('#mobile-summary-total-tagihan').html(totalHtml);
                    $('#mobile-summary-price').text('Rp ' + finalPrice.toLocaleString('id-ID'));
                } else {
                    var totalHtml = '<span class="text-primary fw-bold" style="font-size: 1.4rem;">Rp ' + pkgPrice.toLocaleString('id-ID') + '</span>';
                    $('#summary-total-tagihan').html(totalHtml);
                    $('#mobile-summary-total-tagihan').html(totalHtml);
                    $('#mobile-summary-price').text('Rp ' + pkgPrice.toLocaleString('id-ID'));
                }
            }


            // --- SESSION STORAGE PERSISTENCE ---
            var STORAGE_KEY = 'mindfit_reg_form';

            function saveFormState() {
                var state = {
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    package_ids: activePackageIds,
                    pt_id: activePtId,
                    nutri_id: activeNutriId,
                    discount_code: $('#discount_code').val(),
                    currentStep: currentStep,
                    terms_agree: $('#terms_agree').is(':checked')
                };
                sessionStorage.setItem(STORAGE_KEY, JSON.stringify(state));
            }

            // Save state on every relevant interaction
            $(document).on('change input', '#phone, #address, #discount_code, #terms_agree', function() {
                saveFormState();
            });

            // Clear storage on successful form submission
            $('form').on('submit', function() {
                sessionStorage.removeItem(STORAGE_KEY);
                clearFileFromDB();
            });

            function restoreFormState() {
                var saved = sessionStorage.getItem(STORAGE_KEY);
                if (!saved) return false;

                try {
                    var state = JSON.parse(saved);

                    // Restore text fields
                    if (state.phone) $('#phone').val(state.phone);
                    if (state.address) $('#address').val(state.address);
                    if (state.discount_code) $('#discount_code').val(state.discount_code);

                    // Restore package selections (multi)
                    if (state.package_ids && state.package_ids.length > 0) {
                        activePackageIds = [];
                        for (var i = 0; i < state.package_ids.length; i++) {
                            var pid = state.package_ids[i];
                            var $cb = $('input[name="package_ids[]"][value="' + pid + '"]');
                            if ($cb.length) {
                                $cb.prop('checked', true);
                                $cb.closest('.package-row').addClass('selected');
                                activePackageIds.push(pid);
                            }
                        }
                        updateSelectedPackagesUI();
                    }

                    // Restore PT selection
                    if (state.pt_id) {
                        var $ptRadio = $('input[name="selected_pt_id"][value="' + state.pt_id + '"]');
                        if ($ptRadio.length) {
                            $ptRadio.prop('checked', true).trigger('change');
                            activePtId = state.pt_id;
                            $('#summary-pt-name').text($ptRadio.data('name')).removeClass('text-muted').addClass('text-dark fw-bold');
                            $('#mobile-summary-pt-name').text($ptRadio.data('name')).removeClass('text-muted').addClass('text-dark fw-bold');
                        }
                    }

                    // Restore Nutritionist selection
                    if (state.nutri_id) {
                        var $nutriRadio = $('input[name="selected_nutritionist_id"][value="' + state.nutri_id + '"]');
                        if ($nutriRadio.length) {
                            $nutriRadio.prop('checked', true).trigger('change');
                            activeNutriId = state.nutri_id;
                            $('#summary-nutri-name').text($nutriRadio.data('name')).removeClass('text-muted').addClass('text-dark fw-bold');
                            $('#mobile-summary-nutri-name').text($nutriRadio.data('name')).removeClass('text-muted').addClass('text-dark fw-bold');
                        }
                    }

                    // Restore step
                    if (state.currentStep && state.currentStep > 1) {
                        $('#step-1').hide();
                        $('#step-' + state.currentStep).show();
                        updateProgressIndicators(state.currentStep);
                        currentStep = state.currentStep;
                    }

                    // Restore terms checkbox
                    if (state.terms_agree) {
                        $('#terms_agree').prop('checked', true);
                    }

                    // Restore proof file from IndexedDB
                    getFileFromDB(function(file) {
                        if (file) {
                            try {
                                var container = new DataTransfer();
                                container.items.add(file);
                                $fileInput[0].files = container.files;
                                handleFileSelected(file, false);
                            } catch (err) {
                                console.error("Error restoring file from DB:", err);
                            }
                        }
                    });

                    return true;
                } catch(e) {
                    return false;
                }
            }

            // --- INITIALIZATION ON LOAD ---
            var restoredFromStorage = restoreFormState();

            if (restoredFromStorage) {
                showToast('✨ <b>Your progress has been restored.</b>', 'success');
            } else {
                // 1. Initial updates based on loaded/old values
                $('input[name="package_ids[]"]:checked').each(function() {
                    var val = $(this).val();
                    $(this).closest('.package-row').addClass('selected');
                    if (activePackageIds.indexOf(val) === -1) {
                        activePackageIds.push(val);
                    }
                });
                if (activePackageIds.length > 0) {
                    updateSelectedPackagesUI();
                }

                var initialPt = $('input[name="selected_pt_id"]:checked');
                if (initialPt.length > 0) {
                    var ptName = initialPt.data('name');
                    $('#summary-pt-name').text(ptName).removeClass('text-muted').addClass('text-dark fw-bold');
                    $('#mobile-summary-pt-name').text(ptName).removeClass('text-muted').addClass('text-dark fw-bold');
                }

                var initialNutri = $('input[name="selected_nutritionist_id"]:checked');
                if (initialNutri.length > 0) {
                    var nutriName = initialNutri.data('name');
                    $('#summary-nutri-name').text(nutriName).removeClass('text-muted').addClass('text-dark fw-bold');
                    $('#mobile-summary-nutri-name').text(nutriName).removeClass('text-muted').addClass('text-dark fw-bold');
                }

                // Trigger change styling for coach cards
                $('input.coach-radio:checked').trigger('change');
            }

            var initialCode = $('#discount_code').val();
            if (initialCode && initialCode.trim() !== "") {
                applyDiscountCode(initialCode);
            } else {
                updateTotal();
            }

            // Init steps (only if not already restored to a later step)
            if (!restoredFromStorage || currentStep === 1) {
                updateProgressIndicators(currentStep);
            }
        });

        // Modal Details Helper
        function showPackageDetails(name, desc) {
            $('#pkgModalTitle').text(name);
            $('#pkgModalBody').html(desc || '<p class="text-muted">Tidak ada deskripsi detail untuk paket ini.</p>');
            var myModal = new bootstrap.Modal(document.getElementById('packageDetailModal'));
            myModal.show();
        }
    </script>
@endpush