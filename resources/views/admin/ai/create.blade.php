<x-app-layout>
    <x-slot name="header">Input Data Analisa AI (Admin Mode)</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <i class="fas fa-robot text-primary me-2"></i> Input Data User
                        </div>
                        <a href="{{ route('admin.ai.index') }}" class="btn btn-secondary btn-sm rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ai.store') }}" method="POST">
                        @csrf

                        {{-- Step 1: Identitas --}}
                        <div class="form-section mb-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2"><i
                                    class="fas fa-user-circle me-2"></i> Identitas</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap / Inisial</label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Contoh: Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <div class="d-flex gap-3 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l"
                                                value="Laki-laki" required>
                                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p"
                                                value="Perempuan">
                                            <label class="form-check-label" for="jk_p">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Data Fisik --}}
                        <div class="form-section mb-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2"><i
                                    class="fas fa-ruler-combined me-2"></i> Data Fisik</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Usia (Tahun)</label>
                                    <input type="number" name="usia" class="form-control" placeholder="25" min="10"
                                        max="90" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="170" min="100"
                                        max="250" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Berat Badan (kg)</label>
                                    <input type="number" name="berat" class="form-control" placeholder="70" min="30"
                                        max="200" required>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Riwayat Kesehatan --}}
                        <div class="form-section mb-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2"><i
                                    class="fas fa-notes-medical me-2"></i> Riwayat Kesehatan</h5>
                            <label class="form-label mb-2">Apakah ada riwayat cedera/penyakit berikut? (Boleh pilih
                                lebih dari satu)</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Cedera Lutut" id="c_lutut">
                                        <label class="form-check-label w-100" for="c_lutut">Cedera Lutut</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Cedera Punggung (HNP)" id="c_punggung">
                                        <label class="form-check-label w-100" for="c_punggung">Sakit
                                            Punggung/HNP</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Masalah Jantung" id="c_jantung">
                                        <label class="form-check-label w-100" for="c_jantung">Jantung / Asma</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Vertigo / Darah Tinggi" id="c_vertigo">
                                        <label class="form-check-label w-100" for="c_vertigo">Vertigo /
                                            Hipertensi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Pasca Operasi" id="c_operasi">
                                        <label class="form-check-label w-100" for="c_operasi">Pasca Operasi (< 6
                                                bln)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox p-2 border rounded bg-light">
                                        <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                            value="Tidak Ada" id="c_aman" checked>
                                        <label class="form-check-label w-100 fw-bold text-success" for="c_aman">Tidak
                                            Ada (Sehat)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Aktivitas & Pengalaman --}}
                        <div class="form-section mb-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-running me-2"></i>
                                Aktivitas & Pengalaman</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Frekuensi Olahraga saat ini?</label>
                                <select name="frekuensi_olahraga" class="form-select" required>
                                    <option value="" disabled selected>Pilih salah satu...</option>
                                    <option value="0x (Tidak Pernah)">0x (Tidak Pernah / Jarang Sekali)</option>
                                    <option value="1-2x Seminggu">1-2x Seminggu (Kadang-kadang)</option>
                                    <option value="3x+ Seminggu">3x+ Seminggu (Rutin / Aktif)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pengalaman Nge-Gym / Fitness?</label>
                                <div class="d-flex flex-wrap gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pengalaman_gym" id="exp_new"
                                            value="Belum Pernah" required>
                                        <label class="form-check-label" for="exp_new">Belum Pernah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pengalaman_gym" id="exp_mid"
                                            value="Pernah (Tapi Berhenti)">
                                        <label class="form-check-label" for="exp_mid">Pernah (On-Off)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pengalaman_gym" id="exp_pro"
                                            value="Rutin">
                                        <label class="form-check-label" for="exp_pro">Sudah Rutin</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 5: Lifestyle & Goals --}}
                        <div class="form-section mb-4">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2"><i
                                    class="fas fa-bullseye me-2"></i> Lifestyle & Goals</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pola Makan Saat Ini</label>
                                <select name="pola_makan" class="form-select" required>
                                    <option value="Berantakan" selected>Berantakan (Gorengan, Manis, Tak Teratur)
                                    </option>
                                    <option value="Lumayan">Lumayan (Mencoba mengurangi gula/minyak)</option>
                                    <option value="Ketat/Terkontrol">Ketat / Terkontrol (Hitung Kalori/Makro)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Target Utama (Goal)</label>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_fat"
                                            value="Fat Loss / Kurus" autocomplete="off" required>
                                        <label class="btn btn-outline-primary w-100" for="goal_fat">Fat Loss
                                            (Kurus)</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_muscle"
                                            value="Muscle Gain / Berotot" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100" for="goal_muscle">Muscle Gain
                                            (Otot)</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="target_utama" id="goal_health"
                                            value="Stamina & Kesehatan" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100" for="goal_health">Stamina &
                                            Sehat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Keluhan Spesifik (Opsional)</label>
                                <textarea name="keluhan" class="form-control" rows="2"
                                    placeholder="Contoh: Suka sakit pinggang kalau duduk lama..."></textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg btn-round pulse-button">
                                <i class="fas fa-brain me-2"></i> ANALISA SEKARANG (ADMIN MODE)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Loading Overlay --}}
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center; flex-direction: column;">
        <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
        <h4 class="text-white fw-bold">Sedang Menganalisa...</h4>
        <p class="text-white small">Sabar ya, Admin :)</p>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('loadingOverlay').style.display = 'flex';
            this.querySelector('button[type="submit"]').disabled = true;
        });
    </script>
</x-app-layout>