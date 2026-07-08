<x-app-layout>
    <x-slot name="header">Tambah Klien Baru (Manual / Non-Gadget)</x-slot>

    <!-- Stepper CSS Override -->
    <style>
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
            border-radius: 10px;
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
        .coach-card.border-primary .coach-selected-badge {
            display: flex !important;
            background: #1572E8;
        }
        .coach-card.border-success .coach-selected-badge {
            display: flex !important;
            background: #28a745;
        }
        .package-row {
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .package-row:hover {
            background-color: rgba(0,0,0,0.02);
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <div class="card-title text-white"><i class="fas fa-user-plus me-2"></i>Pendaftaran Klien Offline</div>
                    <div class="card-category text-white-50">Daftarkan klien non-gadget (offline) secara bertahap melalui form terpadu.</div>
                </div>
                <div class="card-body">
                    
                    <!-- Stepper Header -->
                    <div class="d-flex align-items-center justify-content-between mb-5 px-3">
                        <!-- Step 1 Indicator -->
                        <div class="step-indicator active text-center flex-fill" id="step-tab-1" data-step="1">
                            <div class="step-number rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold bg-white text-muted shadow-sm" style="width: 40px; height: 40px;">1</div>
                            <div class="step-label mt-2 text-muted fw-bold">Data Diri</div>
                        </div>
                        <div class="step-connector flex-fill border-top border-2 mx-2 mb-3 border-light" id="step-conn-1" style="margin-top: -12px;"></div>
                        
                        <!-- Step 2 Indicator -->
                        <div class="step-indicator text-center flex-fill" id="step-tab-2" data-step="2">
                            <div class="step-number rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold bg-white text-muted shadow-sm" style="width: 40px; height: 40px;">2</div>
                            <div class="step-label mt-2 text-muted">Paket & Pembimbing</div>
                        </div>
                        <div class="step-connector flex-fill border-top border-2 mx-2 mb-3 border-light" id="step-conn-2" style="margin-top: -12px;"></div>
                        
                        <!-- Step 3 Indicator -->
                        <div class="step-indicator text-center flex-fill" id="step-tab-3" data-step="3">
                            <div class="step-number rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold bg-white text-muted shadow-sm" style="width: 40px; height: 40px;">3</div>
                            <div class="step-label mt-2 text-muted">Konfirmasi</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.clients.store') }}" method="POST" id="manualClientForm">
                        @csrf

                        <!-- ========================================== -->
                        <!-- STEP 1: DATA DIRI                          -->
                        <!-- ========================================== -->
                        <div id="step-1" class="setup-content">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card me-1"></i> 1. Informasi Data Diri Klien
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="name" class="fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama lengkap klien" required>
                                    <div class="invalid-feedback text-danger small d-none" id="name-feedback">Nama lengkap wajib diisi!</div>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="email" class="fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@domain.com" required>
                                    <div class="invalid-feedback text-danger small d-none" id="email-feedback">Masukkan email yang valid!</div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="phone" class="fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Contoh: 08123456789" required>
                                    <div class="invalid-feedback text-danger small d-none" id="phone-feedback">Nomor WhatsApp wajib diisi (Format 08...)!</div>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="gender" class="fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="male">Laki-laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="address" class="fw-bold">Alamat Domisili <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Alamat domisili lengkap klien" required></textarea>
                                <div class="invalid-feedback text-danger small d-none" id="address-feedback">Alamat domisili wajib diisi!</div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="fw-bold">Password Akun Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" value="password123" required>
                                <small class="text-muted d-block mt-1">Default: <code>password123</code></small>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4" id="btnNext1">
                                    Lanjut ke Paket & Coach <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- ========================================== -->
                        <!-- STEP 2: PAKET & COACH                      -->
                        <!-- ========================================== -->
                        <div id="step-2" class="setup-content" style="display:none;">
                            <!-- Package Accordions -->
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-box-open me-1"></i> 2. Pilihan Paket Keanggotaan <span class="text-muted small fw-normal">(bisa pilih lebih dari satu)</span>
                            </h5>

                            @php
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
                                        <div class="card mb-2 border shadow-none" style="border-radius: 8px;">
                                            <div class="card-header p-3 bg-light" id="heading{{ Str::slug($catName) }}" style="cursor: pointer; border-radius: 8px;" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($catName) }}">
                                                <h6 class="mb-0 text-primary fw-bold">
                                                    <i class="fas fa-chevron-right me-2 small"></i> {{ $catName }}
                                                </h6>
                                            </div>

                                            <div id="collapse{{ Str::slug($catName) }}" class="collapse show">
                                                <div class="card-body p-2">
                                                    @foreach($items as $pkg)
                                                        <div class="form-check p-3 border-bottom d-flex align-items-center justify-content-between package-row" data-pkg-id="{{ $pkg->id }}">
                                                            <div>
                                                                <input class="form-check-input package-checkbox" type="checkbox" 
                                                                    name="package_ids[]" 
                                                                    id="pkg{{ $pkg->id }}" 
                                                                    value="{{ $pkg->id }}"
                                                                    data-name="{{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name) }}"
                                                                    data-price="{{ $pkg->price }}">
                                                                <label class="form-check-label fw-bold ms-2 cursor-pointer" for="pkg{{ $pkg->id }}">
                                                                    {{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name) }}
                                                                </label>
                                                                <div class="small text-muted ms-4">
                                                                    Rp {{ number_format($pkg->price, 0, ',', '.') }} 
                                                                    <span class="badge bg-secondary ms-1">{{ $pkg->duration_days }} Hari</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="invalid-feedback text-danger small d-none mt-2" id="package-feedback">Anda wajib memilih minimal satu paket program!</div>
                            </div>

                            <!-- Coach Select Cards -->
                            <hr class="my-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-user-friends me-1"></i> Pilihan Personal Trainer & Nutritionist
                            </h5>
                            
                            <div class="row">
                                <!-- PT Column -->
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold mb-2">Pilih Personal Trainer (PT) <span class="text-danger">*</span></label>
                                    <div class="row row-cols-1 g-2" id="ptList">
                                        @foreach($pts as $coach)
                                            <div class="col">
                                                <div class="card p-2 border coach-card shadow-sm mb-0 cursor-pointer" data-coach-id="{{ $coach->id }}" data-type="pt">
                                                    <div class="coach-selected-badge"><i class="fas fa-check"></i></div>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}" alt="{{ $coach->name }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">{{ $coach->name }}</h6>
                                                            <span class="badge bg-primary text-white" style="font-size: 9px; padding: 2px 6px;">Personal Trainer</span>
                                                            @if($coach->coachProfile && $coach->coachProfile?->specialization)
                                                                <div class="text-muted small mt-1" style="font-size: 0.72rem;">Keahlian: {{ $coach->coachProfile?->specialization }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input coach-radio d-none" type="radio" name="selected_pt_id" value="{{ $coach->id }}" data-name="{{ $coach->name }}" id="coach_pt_{{ $coach->id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="invalid-feedback text-danger small d-none mt-2" id="pt-feedback">Anda wajib memilih salah satu Personal Trainer!</div>
                                </div>

                                <!-- Nutritionist Column -->
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold mb-2">Pilih Nutritionist <span class="text-muted small">(Opsional)</span></label>
                                    <div class="row row-cols-1 g-2" id="nutriList">
                                        @foreach($nutritionists as $coach)
                                            <div class="col">
                                                <div class="card p-2 border coach-card shadow-sm mb-0 cursor-pointer" data-coach-id="{{ $coach->id }}" data-type="nutri">
                                                    <div class="coach-selected-badge"><i class="fas fa-check"></i></div>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $coach->avatar ? asset('storage/' . $coach->avatar) : asset('kaiadmin/img/profile.jpg') }}" alt="{{ $coach->name }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">{{ $coach->name }}</h6>
                                                            <span class="badge bg-success text-white" style="font-size: 9px; padding: 2px 6px;">Nutritionist</span>
                                                            @if($coach->coachProfile && $coach->coachProfile?->specialization)
                                                                <div class="text-muted small mt-1" style="font-size: 0.72rem;">Keahlian: {{ $coach->coachProfile?->specialization }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input coach-radio d-none" type="radio" name="selected_nutritionist_id" value="{{ $coach->id }}" data-name="{{ $coach->name }}" id="coach_nutri_{{ $coach->id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="btnPrev2">
                                    <i class="fas fa-chevron-left me-1"></i> Kembali ke Data Diri
                                </button>
                                <button type="button" class="btn btn-primary px-4" id="btnNext2">
                                    Lanjut ke Ringkasan <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- ========================================== -->
                        <!-- STEP 3: RINGKASAN & KONFIRMASI             -->
                        <!-- ========================================== -->
                        <div id="step-3" class="setup-content" style="display:none;">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-clipboard-check me-1"></i> 3. Ringkasan Pendaftaran Manual
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card border p-3 bg-light" style="border-radius: 8px; min-height: 200px;">
                                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-1"></i> Informasi Klien</h6>
                                        <table class="table table-sm table-borderless text-dark mb-0">
                                            <tr>
                                                <td width="35%" class="fw-bold py-1">Nama</td>
                                                <td width="5%" class="py-1">:</td>
                                                <td id="summary-name" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Email</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-email" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">WhatsApp</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-phone" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Gender</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-gender" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Alamat</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-address" class="py-1">-</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card border p-3 bg-light" style="border-radius: 8px; min-height: 200px;">
                                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-dumbbell me-1"></i> Program & Pembimbing</h6>
                                        <table class="table table-sm table-borderless text-dark mb-0">
                                            <tr>
                                                <td width="35%" class="fw-bold py-1">Paket Terpilih</td>
                                                <td width="5%" class="py-1">:</td>
                                                <td id="summary-packages" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Total Biaya</td>
                                                <td class="py-1">:</td>
                                                <td class="py-1 fw-bold text-success" id="summary-price">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Trainer (PT)</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-pt" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Nutritionist</td>
                                                <td class="py-1">:</td>
                                                <td id="summary-nutritionist" class="py-1">-</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold py-1">Status Bayar</td>
                                                <td class="py-1">:</td>
                                                <td class="py-1"><span class="badge bg-success text-white">Lunas / Approved</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 shadow-sm mt-2 text-dark" style="border-radius: 8px; background-color: rgba(21,114,232,0.08);">
                                <h6 class="fw-bold mb-1"><i class="fas fa-info-circle me-1"></i> Catatan Pendaftaran Manual</h6>
                                <p class="mb-0 small">Klien akan langsung didaftarkan secara aktif ke dalam database, status premium langsung aktif, invoice ditandai lunas, dan relasi coach-client akan langsung dipetakan. Klien dapat masuk ke aplikasi menggunakan email mereka dan password default yang Anda tentukan.</p>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="btnPrev3">
                                    <i class="fas fa-chevron-left me-1"></i> Kembali ke Pilihan
                                </button>
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="fas fa-save me-1"></i> Daftarkan & Aktifkan Klien
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Function to validate Step 1 inputs
            function validateStep1() {
                var isValid = true;
                
                var name = $('#name').val().trim();
                if (name === '') {
                    $('#name').addClass('is-invalid');
                    $('#name-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#name').removeClass('is-invalid');
                    $('#name-feedback').addClass('d-none');
                }

                var email = $('#email').val().trim();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (email === '' || !emailReg.test(email)) {
                    $('#email').addClass('is-invalid');
                    $('#email-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#email-feedback').addClass('d-none');
                }

                var phone = $('#phone').val().trim();
                if (phone === '') {
                    $('#phone').addClass('is-invalid');
                    $('#phone-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#phone').removeClass('is-invalid');
                    $('#phone-feedback').addClass('d-none');
                }

                var address = $('#address').val().trim();
                if (address === '') {
                    $('#address').addClass('is-invalid');
                    $('#address-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#address').removeClass('is-invalid');
                    $('#address-feedback').addClass('d-none');
                }

                return isValid;
            }

            // Function to validate Step 2 inputs
            function validateStep2() {
                var isValid = true;

                // Validate packages selected
                var packagesSelected = $('.package-checkbox:checked').length;
                if (packagesSelected === 0) {
                    $('#package-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#package-feedback').addClass('d-none');
                }

                // Validate PT selected
                var ptSelected = $('input[name="selected_pt_id"]:checked').length;
                if (ptSelected === 0) {
                    $('#pt-feedback').removeClass('d-none');
                    isValid = false;
                } else {
                    $('#pt-feedback').addClass('d-none');
                }

                return isValid;
            }

            // Populate Step 3 Summary
            function populateSummary() {
                $('#summary-name').text($('#name').val());
                $('#summary-email').text($('#email').val());
                $('#summary-phone').text($('#phone').val());
                $('#summary-gender').text($('#gender').val() === 'male' ? 'Laki-laki' : 'Perempuan');
                $('#summary-address').text($('#address').val());

                // Selected Packages list & Total price
                var selectedPkgs = [];
                var totalPrice = 0;
                $('.package-checkbox:checked').each(function() {
                    selectedPkgs.push($(this).data('name'));
                    totalPrice += parseFloat($(this).data('price'));
                });
                $('#summary-packages').text(selectedPkgs.join(' + '));
                
                // Format price
                var formattedPrice = 'Rp ' + totalPrice.toLocaleString('id-ID');
                $('#summary-price').text(formattedPrice);

                // Selected PT
                var selectedPtName = $('input[name="selected_pt_id"]:checked').data('name');
                $('#summary-pt').text(selectedPtName || '-');

                // Selected Nutritionist
                var selectedNutriName = $('input[name="selected_nutritionist_id"]:checked').data('name');
                $('#summary-nutritionist').text(selectedNutriName || 'Tidak memilih');
            }

            // Stepper Navigation Handlers
            $('#btnNext1').click(function() {
                if (validateStep1()) {
                    // Update header indicator
                    $('#step-tab-1').removeClass('active').addClass('completed');
                    $('#step-conn-1').addClass('completed');
                    $('#step-tab-2').addClass('active');

                    // Show next view
                    $('#step-1').hide();
                    $('#step-2').fadeIn(300);
                }
            });

            // Prevent form submit on Enter key press in text inputs
            $('#manualClientForm input').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            $('#btnPrev2').click(function() {
                // Update header indicator
                $('#step-tab-2').removeClass('active');
                $('#step-conn-1').removeClass('completed');
                $('#step-tab-1').removeClass('completed').addClass('active');

                // Show prev view
                $('#step-2').hide();
                $('#step-1').fadeIn(300);
            });

            $('#btnNext2').click(function() {
                if (validateStep2()) {
                    populateSummary();
                    
                    // Update header indicator
                    $('#step-tab-2').removeClass('active').addClass('completed');
                    $('#step-conn-2').addClass('completed');
                    $('#step-tab-3').addClass('active');

                    // Show next view
                    $('#step-2').hide();
                    $('#step-3').fadeIn(300);
                }
            });

            $('#btnPrev3').click(function() {
                // Update header indicator
                $('#step-tab-3').removeClass('active');
                $('#step-conn-2').removeClass('completed');
                $('#step-tab-2').removeClass('completed').addClass('active');

                // Show prev view
                $('#step-3').hide();
                $('#step-2').fadeIn(300);
            });

            // Card click behavior for PT & Nutritionists
            $('.coach-card').click(function() {
                var card = $(this);
                var type = card.data('type');
                var radio = card.find('.coach-radio');

                if (type === 'pt') {
                    // Unselect other PTs
                    $('#ptList .coach-card').removeClass('border-primary');
                    card.addClass('border-primary');
                    radio.prop('checked', true);
                    $('#pt-feedback').addClass('d-none');
                } else if (type === 'nutri') {
                    // Check if already selected, allow toggling off if clicked again
                    if (radio.is(':checked')) {
                        card.removeClass('border-success');
                        radio.prop('checked', false);
                    } else {
                        // Unselect other nutritionists
                        $('#nutriList .coach-card').removeClass('border-success');
                        card.addClass('border-success');
                        radio.prop('checked', true);
                    }
                }
            });

            // If old values exist (e.g. from session/validation redirects), initialize selections
            $('.coach-radio:checked').each(function() {
                var radio = $(this);
                var card = radio.closest('.coach-card');
                var type = card.data('type');
                
                if (type === 'pt') {
                    card.addClass('border-primary');
                } else if (type === 'nutri') {
                    card.addClass('border-success');
                }
            });

            // Package row click helper
            $('.package-row').click(function(e) {
                if ($(e.target).is('input') || $(e.target).is('label')) {
                    return; // let standard click handle it
                }
                var cb = $(this).find('.package-checkbox');
                cb.prop('checked', !cb.prop('checked'));
                $('#package-feedback').addClass('d-none');
            });
        });
    </script>
    @endpush
</x-app-layout>
