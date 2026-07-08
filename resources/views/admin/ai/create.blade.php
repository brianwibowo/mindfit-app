<x-app-layout>
    <x-slot name="header">Input Data Analisa AI (Admin Mode)</x-slot>

    <!-- Custom CSS for Premium Forms & Selectors -->
    <style>
        .form-section-title {
            font-size: 0.95rem;
            color: #5c55e3;
            font-weight: 700;
            border-bottom: 2px solid rgba(92, 85, 227, 0.08);
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .form-label {
            font-size: 0.8rem;
            color: #2c3e50;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border-radius: 8px !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            padding: 10px 14px !important;
            font-size: 0.85rem !important;
            transition: all 0.2s ease !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5c55e3 !important;
            box-shadow: 0 0 0 3px rgba(92, 85, 227, 0.15) !important;
        }
        
        /* Card Checkboxes */
        .card-checkbox {
            transition: all 0.2s ease;
            cursor: pointer;
            border-color: rgba(0,0,0,0.08) !important;
            background: #fff;
            border-radius: 8px !important;
            padding: 12px 14px !important;
            display: flex;
            align-items: center;
        }
        .card-checkbox:hover {
            border-color: #5c55e3 !important;
            background-color: rgba(92, 85, 227, 0.02) !important;
        }
        .card-checkbox .form-check-input {
            margin-top: 0;
            cursor: pointer;
        }
        .card-checkbox .form-check-input:checked {
            background-color: #5c55e3 !important;
            border-color: #5c55e3 !important;
        }
        .card-checkbox .form-check-label {
            cursor: pointer;
            font-size: 0.82rem;
            color: #2c3e50;
            font-weight: 500;
            margin-left: 8px;
        }

        /* Goal Radio Buttons (Segmented look) */
        .btn-check:checked + .btn-outline-primary {
            background-color: #5c55e3 !important;
            border-color: #5c55e3 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(92, 85, 227, 0.2) !important;
        }
        .btn-outline-primary {
            border: 1px solid rgba(92, 85, 227, 0.3) !important;
            color: #5c55e3 !important;
            font-weight: 600;
            font-size: 0.82rem;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            transition: all 0.2s ease !important;
        }
        .btn-outline-primary:hover {
            background-color: rgba(92, 85, 227, 0.04) !important;
            border-color: #5c55e3 !important;
            color: #5c55e3 !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header bg-white p-4" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark" style="font-size: 1.15rem;">
                                <i class="fas fa-robot text-primary me-2"></i> Input Data User
                            </h4>
                            <p class="text-muted text-xs mb-0">Isi formulir kebutuhan user secara lengkap untuk diproses oleh kecerdasan buatan.</p>
                        </div>
                        <a href="{{ route('admin.ai.index') }}" class="btn btn-light btn-round btn-sm px-3 border">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.ai.store') }}" method="POST">
                        @csrf

                        {{-- Step 1: Identitas --}}
                        <div class="form-section mb-4">
                            <h5 class="form-section-title">
                                <i class="fas fa-user-circle me-2"></i> Identitas Klien
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap / Inisial <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Contoh: Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold d-block mb-2">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l"
                                                value="Laki-laki" required style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold text-dark" for="jk_l" style="cursor: pointer; font-size: 0.85rem;">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p"
                                                value="Perempuan" style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold text-dark" for="jk_p" style="cursor: pointer; font-size: 0.85rem;">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Data Fisik --}}
                        <div class="form-section mb-4">
                            <h5 class="form-section-title">
                                <i class="fas fa-ruler-combined me-2"></i> Pengukuran Fisik
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Usia (Tahun) <span class="text-danger">*</span></label>
                                    <input type="number" name="usia" class="form-control" placeholder="Contoh: 25" min="10"
                                        max="90" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="Contoh: 170" min="100"
                                        max="250" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Berat Badan (kg) <span class="text-danger">*</span></label>
                                    <input type="number" name="berat" class="form-control" placeholder="Contoh: 70" min="30"
                                        max="200" required>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Riwayat Kesehatan --}}
                        <div class="form-section mb-4">
                            <h5 class="form-section-title">
                                <i class="fas fa-notes-medical me-2"></i> Riwayat Cedera & Kesehatan
                            </h5>
                            <label class="form-label fw-semibold text-muted mb-3">Apakah ada riwayat cedera/penyakit berikut? (Bisa pilih lebih dari satu)</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Cedera Lutut" id="c_lutut">
                                        <label class="form-check-label w-100" for="c_lutut">Cedera Lutut</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Cedera Punggung (HNP)" id="c_punggung">
                                        <label class="form-check-label w-100" for="c_punggung">Cedera Punggung/HNP</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Masalah Jantung" id="c_jantung">
                                        <label class="form-check-label w-100" for="c_jantung">Jantung / Asma</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Vertigo / Darah Tinggi" id="c_vertigo">
                                        <label class="form-check-label w-100" for="c_vertigo">Vertigo / Hipertensi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Pasca Operasi" id="c_operasi">
                                        <label class="form-check-label w-100" for="c_operasi">Pasca Operasi (< 6 bln)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox border bg-light-success" style="background-color: rgba(46, 204, 113, 0.05) !important;">
                                        <input class="form-check-input text-success" type="checkbox" name="riwayat_cedera[]"
                                            value="Tidak Ada" id="c_aman" checked>
                                        <label class="form-check-label w-100 fw-bold text-success" for="c_aman">Tidak Ada (Sehat)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Aktivitas & Pengalaman --}}
                        <div class="form-section mb-4">
                            <h5 class="form-section-title">
                                <i class="fas fa-running me-2"></i> Aktivitas & Pengalaman Fitness
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Frekuensi Olahraga Saat Ini <span class="text-danger">*</span></label>
                                    <select name="frekuensi_olahraga" class="form-select" required>
                                        <option value="" disabled selected>Pilih frekuensi...</option>
                                        <option value="0x (Tidak Pernah)">0x (Tidak Pernah / Jarang Sekali)</option>
                                        <option value="1-2x Seminggu">1-2x Seminggu (Kadang-kadang)</option>
                                        <option value="3x+ Seminggu">3x+ Seminggu (Rutin / Aktif)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pengalaman Gym / Angkat Beban <span class="text-danger">*</span></label>
                                    <select name="pengalaman_gym" class="form-select" required>
                                        <option value="" disabled selected>Pilih pengalaman gym...</option>
                                        <option value="Belum Pernah">Belum Pernah</option>
                                        <option value="Pernah (Tapi Berhenti)">Pernah (On-Off)</option>
                                        <option value="Rutin">Sudah Rutin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Step 5: Lifestyle & Goals --}}
                        <div class="form-section mb-4">
                            <h5 class="form-section-title">
                                <i class="fas fa-bullseye me-2"></i> Gaya Hidup & Target Utama
                            </h5>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pola Makan Sehari-hari <span class="text-danger">*</span></label>
                                <select name="pola_makan" class="form-select" required>
                                    <option value="Berantakan" selected>Berantakan (Sering gorengan, manis, tidak teratur)</option>
                                    <option value="Lumayan">Lumayan (Mulai membatasi gula/minyak, porsi sedang)</option>
                                    <option value="Ketat/Terkontrol">Ketat / Terkontrol (Menghitung kalori dan nutrisi makro)</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block mb-3">Target Utama Program (Goal) <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_fat"
                                            value="Fat Loss / Kurus" autocomplete="off" required>
                                        <label class="btn btn-outline-primary w-100 text-center" for="goal_fat">
                                            <i class="fas fa-fire me-1.5"></i> Fat Loss (Kurus)
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_muscle"
                                            value="Muscle Gain / Berotot" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 text-center" for="goal_muscle">
                                            <i class="fas fa-dumbbell me-1.5"></i> Muscle Gain (Otot)
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_health"
                                            value="Stamina & Kesehatan" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 text-center" for="goal_health">
                                            <i class="fas fa-heartbeat me-1.5"></i> Stamina & Sehat
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Keluhan Spesifik / Batasan Fisik (Opsional)</label>
                                <textarea name="keluhan" class="form-control" rows="3"
                                    placeholder="Contoh: Sering nyeri pinggang bawah saat duduk lama, bahu kanan pernah cedera ringan..."></textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg btn-round fw-bold py-3" style="background: #5c55e3; border: none; box-shadow: 0 4px 15px rgba(92, 85, 227, 0.35);">
                                <i class="fas fa-brain me-2"></i> ANALISA DATA SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Loading Overlay --}}
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; backdrop-filter: blur(5px);">
        <div class="spinner-border text-light mb-3" role="status" style="width: 3.5rem; height: 3.5rem;"></div>
        <h4 class="text-white fw-bold">Sedang Menganalisa Data...</h4>
        <p class="text-white opacity-75 small">Kecerdasan Buatan sedang merumuskan BMR, TDEE, dan Rekomendasi Program.</p>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('loadingOverlay').style.display = 'flex';
            this.querySelector('button[type="submit"]').disabled = true;
        });

        // Uncheck 'Tidak Ada (Sehat)' when selecting specific injuries, and vice versa
        const safetyCheck = document.getElementById('c_aman');
        const specificChecks = [
            document.getElementById('c_lutut'),
            document.getElementById('c_punggung'),
            document.getElementById('c_jantung'),
            document.getElementById('c_vertigo'),
            document.getElementById('c_operasi')
        ];

        safetyCheck.addEventListener('change', function() {
            if(this.checked) {
                specificChecks.forEach(c => c.checked = false);
            }
        });

        specificChecks.forEach(c => {
            c.addEventListener('change', function() {
                if(this.checked) {
                    safetyCheck.checked = false;
                }
            });
        });
    </script>
</x-app-layout>