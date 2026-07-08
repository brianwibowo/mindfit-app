<x-app-layout>
    <x-slot name="header">Fitur AI (MindFit Intelligence)</x-slot>

    <style>
        .bg-light-blue {
            background-color: #f0f6ff !important;
        }
        .form-check.card.border-primary {
            border-color: #1d7af3 !important;
        }
        .form-check.card {
            transition: all 0.2s ease-in-out;
        }
        .form-check.card:hover {
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }
        .step-indicator {
            transition: all 0.2s ease-in-out;
        }
        .step-indicator.active {
            color: #1d7af3;
        }
        .step-indicator.completed {
            color: #28a745;
        }
        .toast-mindfit {
            border-left: 4px solid #ff9800;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }

        /* Stepper alignment helper */
        @media (max-width: 575.98px) {
            .step-connector {
                margin-top: 0 !important;
                margin-bottom: 8px !important;
            }
        }
        @media (min-width: 576px) {
            .step-connector {
                margin-top: -12px !important;
            }
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0 text-white fw-bold">
                            <i class="fas fa-brain me-2 text-warning animate__animated animate__pulse animate__infinite"></i> Analisa Kebutuhan Program
                        </div>
                        <a href="{{ route('client.ai.history') }}"
                            class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark">
                            <i class="fas fa-history me-1"></i> Riwayat Analisa
                        </a>
                    </div>
                </div>

                <!-- Stepper Progress Bar -->
                <div class="p-3 bg-light border-bottom">
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="step-indicator active text-center flex-fill" id="step-tab-1" data-step="1">
                            <span class="badge rounded-circle bg-primary text-white mb-1 px-2 py-1" id="step-badge-1">1</span>
                            <div class="small fw-bold d-none d-sm-block">Profil & Fisik</div>
                        </div>
                        <div class="step-connector flex-fill border-top border-2 border-light mx-2" id="step-conn-1"></div>
                        <div class="step-indicator text-center flex-fill" id="step-tab-2" data-step="2">
                            <span class="badge rounded-circle bg-secondary text-white mb-1 px-2 py-1" id="step-badge-2">2</span>
                            <div class="small fw-bold d-none d-sm-block">Kesehatan & Olahraga</div>
                        </div>
                        <div class="step-connector flex-fill border-top border-2 border-light mx-2" id="step-conn-2"></div>
                        <div class="step-indicator text-center flex-fill" id="step-tab-3" data-step="3">
                            <span class="badge rounded-circle bg-secondary text-white mb-1 px-2 py-1" id="step-badge-3">3</span>
                            <div class="small fw-bold d-none d-sm-block">Gaya Hidup & Target</div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 text-dark">
                    <form action="{{ route('client.ai.analyze') }}" method="POST" id="aiForm">
                        @csrf

                        <!-- STEP 1: Profil & Fisik -->
                        <div id="step-1" class="setup-content">
                            <div class="section-title mb-4 fw-bold text-primary border-bottom pb-2">
                                <i class="fas fa-user-circle me-1"></i> Langkah 1: Profil & Data Fisik
                            </div>
                            
                            <div class="form-group mb-3 p-0">
                                <label class="form-label fw-bold mb-1 text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control text-dark" value="{{ Auth::user()->name }}" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-2 p-0">
                                        <label class="form-label fw-bold mb-1 text-dark">Usia (Tahun) <span class="text-danger">*</span></label>
                                        <input type="number" name="usia" class="form-control text-dark" placeholder="Contoh: 25" required min="10" max="90">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2 p-0">
                                        <label class="form-label fw-bold d-block mb-2 text-dark">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                                    <input class="form-check-input mt-0" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" required style="margin-left: 0; position: static;">
                                                    <span class="ms-2 fw-bold text-dark small"><i class="fas fa-mars text-primary me-1"></i> Laki-laki</span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                                    <input class="form-check-input mt-0" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" style="margin-left: 0; position: static;">
                                                    <span class="ms-2 fw-bold text-dark small"><i class="fas fa-venus text-danger me-1"></i> Perempuan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 p-0">
                                        <label class="form-label fw-bold mb-1 text-dark">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                        <input type="number" name="tinggi" class="form-control text-dark" placeholder="Contoh: 170" required min="100" max="250">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 p-0">
                                        <label class="form-label fw-bold mb-1 text-dark">Berat Badan (kg) <span class="text-danger">*</span></label>
                                        <input type="number" name="berat" class="form-control text-dark" placeholder="Contoh: 65" required min="30" max="200">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: Kesehatan & Olahraga -->
                        <div id="step-2" class="setup-content" style="display:none;">
                            <div class="section-title mb-4 fw-bold text-primary border-bottom pb-2">
                                <i class="fas fa-running me-1"></i> Langkah 2: Kesehatan & Aktivitas Fisik
                            </div>

                            <div class="form-group mb-3 p-0">
                                <label class="form-label fw-bold mb-1 text-dark">Frekuensi Olahraga (per Minggu) <span class="text-danger">*</span></label>
                                <select name="frekuensi_olahraga" class="form-select text-dark" required>
                                    <option value="" disabled selected>Pilih frekuensi...</option>
                                    <option value="0x (Jarang sekali)">0x (Jarang sekali / Pemula)</option>
                                    <option value="1-2x (Kadang-kadang)">1-2x (Kadang-kadang)</option>
                                    <option value="3x atau lebih (Rutin)">3x atau lebih (Rutin / Aktif)</option>
                                </select>
                            </div>

                            <div class="form-group mb-4 p-0">
                                <label class="form-label fw-bold d-block mb-2 text-dark">Pengalaman Gym / Alat Fitness <span class="text-danger">*</span></label>
                                <div class="row row-cols-1 row-cols-sm-3 g-2">
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pengalaman_gym" value="Belum Pernah" id="exp_new" required style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Belum Pernah</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pengalaman_gym" value="Pernah (Dulu), Sekarang Lupa" id="exp_mid" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Pernah (Dulu)</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pengalaman_gym" value="Rutin / Paham Teknik" id="exp_pro" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Rutin / Paham</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-2 p-0">
                                <label class="form-label fw-bold d-block mb-2 text-dark">Apakah ada cedera atau kondisi medis? <span class="text-danger">*</span> <span class="text-muted small">(Boleh pilih lebih dari satu)</span></label>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="checkbox" name="riwayat_cedera[]" value="Tidak Ada" id="cedera_none" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small"><i class="fas fa-heart text-success me-1"></i> Tidak Ada (Sehat)</span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0 medis-item" type="checkbox" name="riwayat_cedera[]" value="Cedera Lutut/Ankle" id="cedera_lutut" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Cedera Lutut / Ankle</span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0 medis-item" type="checkbox" name="riwayat_cedera[]" value="Cedera Bahu/Punggung" id="cedera_bahu" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Cedera Bahu / Punggung</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0 medis-item" type="checkbox" name="riwayat_cedera[]" value="Asma/Sesak" id="cedera_asma" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Asma / Sesak</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0 medis-item" type="checkbox" name="riwayat_cedera[]" value="Diabetes/Hipertensi" id="cedera_gula" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Diabetes</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0 medis-item" type="checkbox" name="riwayat_cedera[]" value="Masalah Jantung" id="cedera_jantung" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Jantung</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: Gaya Hidup & Target -->
                        <div id="step-3" class="setup-content" style="display:none;">
                            <div class="section-title mb-4 fw-bold text-primary border-bottom pb-2">
                                <i class="fas fa-apple-alt me-1"></i> Langkah 3: Gaya Hidup & Target Program
                            </div>

                            <div class="form-group mb-3 p-0">
                                <label class="form-label fw-bold d-block mb-2 text-dark">Pola Makan Saat Ini <span class="text-danger">*</span></label>
                                <div class="row row-cols-1 row-cols-sm-3 g-2">
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pola_makan" value="Berantakan" id="eat_poor" required style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Berantakan</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pola_makan" value="Lumayan" id="eat_mid" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Lumayan Sehat</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="pola_makan" value="Ketat" id="eat_strict" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Sangat Ketat</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3 p-0">
                                <label class="form-label fw-bold d-block mb-2 text-dark">Target Utama Kamu <span class="text-danger">*</span></label>
                                <div class="row row-cols-1 row-cols-sm-2 g-2">
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="target_utama" value="Fat Loss" id="goal_fat" required style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Fat Loss</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="target_utama" value="Muscle Gain" id="goal_muscle" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Muscle Gain</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="target_utama" value="Performa" id="goal_sport" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Performa Atletik</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-check card p-2 border mb-0 shadow-sm d-flex flex-row align-items-center" style="cursor: pointer;">
                                            <input class="form-check-input mt-0" type="radio" name="target_utama" value="Sehat & Bugar" id="goal_health" style="margin-left: 0; position: static;">
                                            <span class="ms-2 fw-bold text-dark small">Kebugaran</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-2 p-0">
                                <label class="form-label fw-bold mb-1 text-dark">Keluhan Spesifik / Tambahan <span class="text-muted">(Opsional)</span></label>
                                <textarea name="keluhan" class="form-control text-dark" rows="3" placeholder="Contoh: Sakit pinggang kalau duduk lama..."></textarea>
                            </div>
                        </div>

                        <!-- Stepper Buttons -->
                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <button type="button" class="btn btn-outline-secondary px-4" id="btn-prev" style="display: none;">
                                <i class="fas fa-chevron-left me-1"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary px-4 ms-auto" id="btn-next">
                                Lanjut <i class="fas fa-chevron-right ms-1"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="bg-white p-4 rounded text-center shadow-lg"
            style="min-width: 320px; border-top: 5px solid #1d7af3;">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
            <h4 class="text-dark fw-bold">Tunggu Hasil...</h4>
            <p class="text-muted small mb-0">AI sedang memproses datamu.</p>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; max-width: 350px; width: 100%;">
        <div id="validationToast" class="toast fade toast-mindfit bg-white w-100 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-warning text-dark">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong class="me-auto">Perhatian</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastBody" style="font-size: 0.9rem; padding: 12px; color: #333;">
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                var currentStep = 1;

                // --- TOAST NOTIFICATION UTILITY ---
                function showToast(message) {
                    $('#toastBody').html(message);
                    var toastEl = document.getElementById('validationToast');
                    if (window.bootstrap && bootstrap.Toast) {
                        var existing = bootstrap.Toast.getInstance(toastEl);
                        if (existing) {
                            existing.dispose();
                        }
                        var bsToast = new bootstrap.Toast(toastEl, { delay: 4000, animation: true });
                        bsToast.show();
                    }
                }

                // --- PROGRESS INDICATORS ---
                function updateProgressIndicators(step) {
                    $('.step-indicator').removeClass('active completed');
                    $('.step-connector').removeClass('active completed');

                    for (var i = 1; i < step; i++) {
                        $('#step-tab-' + i).addClass('completed');
                        $('#step-badge-' + i).removeClass('bg-primary bg-secondary').addClass('bg-success');
                        $('#step-conn-' + i).addClass('completed').css('border-top-color', '#28a745');
                    }

                    $('#step-tab-' + step).addClass('active');
                    $('#step-badge-' + step).removeClass('bg-secondary bg-success').addClass('bg-primary');
                }

                // --- STEP VALIDATIONS ---
                function validateStep1() {
                    var name = $('input[name="nama"]').val().trim();
                    var usia = $('input[name="usia"]').val();
                    var gender = $('input[name="jenis_kelamin"]:checked').val();
                    var tinggi = $('input[name="tinggi"]').val();
                    var berat = $('input[name="berat"]').val();

                    if (name === "" || !usia || !gender || !tinggi || !berat) {
                        return false;
                    }
                    if (usia < 10 || usia > 90 || tinggi < 100 || tinggi > 250 || berat < 30 || berat > 200) {
                        return false;
                    }
                    return true;
                }

                function validateStep2() {
                    var freq = $('select[name="frekuensi_olahraga"]').val();
                    var exp = $('input[name="pengalaman_gym"]:checked').val();
                    var injuries = $('input[name="riwayat_cedera[]"]:checked').length > 0;

                    if (!freq || !exp || !injuries) {
                        return false;
                    }
                    return true;
                }

                function validateStep3() {
                    var eat = $('input[name="pola_makan"]:checked').val();
                    var target = $('input[name="target_utama"]:checked').val();

                    if (!eat || !target) {
                        return false;
                    }
                    return true;
                }

                // --- STEP TRANSITIONS ---
                function goToStep(step) {
                    if (step < 1 || step > 3) return;

                    // Validation checks before moving forward
                    if (step > currentStep) {
                        if (currentStep === 1 && !validateStep1()) {
                            showToast('⚠️ <b>Harap lengkapi semua data diri & ukuran fisik dengan benar!</b>');
                            return;
                        }
                        if (currentStep === 2 && !validateStep2()) {
                            showToast('⚠️ <b>Harap lengkapi frekuensi, pengalaman gym, dan riwayat kesehatan!</b>');
                            return;
                        }
                    }

                    // Perform view hide/show
                    $('#step-' + currentStep).hide();
                    $('#step-' + step).show();

                    currentStep = step;
                    updateProgressIndicators(step);

                    // Update buttons
                    if (currentStep === 1) {
                        $('#btn-prev').hide();
                        $('#btn-next').html('Lanjut <i class="fas fa-chevron-right ms-1"></i>').removeClass('btn-success btn-lg w-100 mt-2').addClass('btn-primary');
                        $('.d-flex.justify-content-between').addClass('justify-content-between').removeClass('flex-column');
                    } else if (currentStep === 2) {
                        $('#btn-prev').show();
                        $('#btn-next').html('Lanjut <i class="fas fa-chevron-right ms-1"></i>').removeClass('btn-success btn-lg w-100 mt-2').addClass('btn-primary');
                        $('.d-flex.justify-content-between').addClass('justify-content-between').removeClass('flex-column');
                    } else if (currentStep === 3) {
                        $('#btn-prev').show();
                        $('#btn-next').html('<i class="fas fa-search me-1"></i> ANALISA SAYA SEKARANG').removeClass('btn-primary').addClass('btn-success');
                    }
                }

                $('#btn-next').on('click', function() {
                    if (currentStep === 3) {
                        if (!validateStep3()) {
                            showToast('⚠️ <b>Harap pilih pola makan & target utama Anda!</b>');
                            return;
                        }
                        $('#aiForm').submit();
                    } else {
                        goToStep(currentStep + 1);
                    }
                });

                $('#btn-prev').on('click', function() {
                    goToStep(currentStep - 1);
                });

                // Stepper bar clicking (only backward or to validated steps)
                $('.step-indicator').on('click', function() {
                    var targetStep = parseInt($(this).data('step'));
                    if (targetStep < currentStep) {
                        goToStep(targetStep);
                    }
                });

                // --- PREMIUM CARD HIGHLIGHTING LOGIC ---
                // Initialize checked styles on page load
                $('input[type="radio"], input[type="checkbox"]').each(function() {
                    var $card = $(this).closest('.card');
                    if ($card.length && this.checked) {
                        $card.addClass('border-primary bg-light-blue').css('border-width', '2px');
                    }
                });

                // Handle Highlight on Change for all checkboxes and radios inside .card
                $(document).on('change', 'input[type="radio"], input[type="checkbox"]', function() {
                    var name = $(this).attr('name');
                    if ($(this).attr('type') === 'radio') {
                        $('input[name="' + name + '"]').each(function() {
                            var $card = $(this).closest('.card');
                            if (this.checked) {
                                $card.addClass('border-primary bg-light-blue').css('border-width', '2px');
                            } else {
                                $card.removeClass('border-primary bg-light-blue').css('border-width', '1px');
                            }
                        });
                    } else {
                        var $card = $(this).closest('.card');
                        if (this.checked) {
                            $card.addClass('border-primary bg-light-blue').css('border-width', '2px');
                        } else {
                            $card.removeClass('border-primary bg-light-blue').css('border-width', '1px');
                        }
                    }
                });

                // Click-to-deselect behavior for all radio buttons in the form
                var lastCheckedRadios = {};
                
                $('input[type="radio"]:checked').each(function() {
                    var name = $(this).attr('name');
                    lastCheckedRadios[name] = this;
                });

                $(document).on('click', 'input[type="radio"]', function() {
                    var name = $(this).attr('name');
                    if (this === lastCheckedRadios[name]) {
                        this.checked = false;
                        lastCheckedRadios[name] = null;
                        $(this).prop('checked', false).trigger('change');
                    } else {
                        lastCheckedRadios[name] = this;
                        $(this).trigger('change');
                    }
                });

                // Handle injury checkboxes mutually exclusive logic
                $('#cedera_none').on('change', function() {
                    if (this.checked) {
                        $('.medis-item').prop('checked', false).trigger('change');
                    }
                });

                $('.medis-item').on('change', function() {
                    if (this.checked) {
                        $('#cedera_none').prop('checked', false).trigger('change');
                    }
                });

                // Loading Handler
                $('#aiForm').on('submit', function () {
                    $('#loadingOverlay').css('display', 'flex');
                    $('#btn-next').prop('disabled', true);
                });
            });
        </script>
    @endpush
</x-app-layout>