<x-app-layout>
    <x-slot name="header">Fitur AI (MindFit Intelligence)</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <i class="fas fa-brain text-primary me-2"></i> Analisa Kebutuhan Program
                        </div>
                        <a href="{{ route('client.ai.history') }}"
                            class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="fas fa-history me-1"></i> Riwayat Analisa
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.ai.analyze') }}" method="POST">
                        @csrf

                        {{-- 1. Profil --}}
                        <div class="section-title mt-2 mb-3 fw-bold text-primary border-bottom pb-2">1. Profil Diri
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ Auth::user()->name }}"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l"
                                    value="Laki-laki" required>
                                <label class="form-check-label" for="jk_l">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p"
                                    value="Perempuan">
                                <label class="form-check-label" for="jk_p">Perempuan</label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Usia (Tahun)</label>
                            <input type="number" name="usia" class="form-control" placeholder="Contoh: 25" required
                                min="10" max="90">
                        </div>

                        {{-- 2. Antropometri --}}
                        <div class="section-title mt-4 mb-3 fw-bold text-primary border-bottom pb-2">2. Data Fisik</div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="Contoh: 170"
                                        required min="100" max="250">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Berat Badan (kg)</label>
                                    <input type="number" name="berat" class="form-control" placeholder="Contoh: 65"
                                        required min="30" max="200">
                                </div>
                            </div>
                        </div>

                        {{-- 3. Kesehatan --}}
                        <div class="section-title mt-4 mb-3 fw-bold text-primary border-bottom pb-2">3. Riwayat
                            Kesehatan</div>

                        <div class="form-group mb-3">
                            <label class="form-label d-block">Apakah ada cedera atau kondisi medis? (Boleh pilih lebih
                                dari satu)</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="riwayat_cedera[]"
                                    value="Tidak Ada" id="cedera_none" onclick="toggleMedis(this)">
                                <label class="form-check-label" for="cedera_none">Tidak Ada (Sehat)</label>
                            </div>
                            <div class="medis-options">
                                <div class="form-check">
                                    <input class="form-check-input medis-item" type="checkbox" name="riwayat_cedera[]"
                                        value="Cedera Lutut/Ankle" id="cedera_lutut">
                                    <label class="form-check-label" for="cedera_lutut">Cedera Lutut / Ankle</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input medis-item" type="checkbox" name="riwayat_cedera[]"
                                        value="Cedera Bahu/Punggung" id="cedera_bahu">
                                    <label class="form-check-label" for="cedera_bahu">Cedera Bahu / Punggung / Syaraf
                                        Kejepit</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input medis-item" type="checkbox" name="riwayat_cedera[]"
                                        value="Asma/Sesak" id="cedera_asma">
                                    <label class="form-check-label" for="cedera_asma">Asma / Sesak Nafas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input medis-item" type="checkbox" name="riwayat_cedera[]"
                                        value="Diabetes/Hipertensi" id="cedera_gula">
                                    <label class="form-check-label" for="cedera_gula">Diabetes / Hipertensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input medis-item" type="checkbox" name="riwayat_cedera[]"
                                        value="Masalah Jantung" id="cedera_jantung">
                                    <label class="form-check-label" for="cedera_jantung">Masalah Jantung (Butuh Izin
                                        Dokter)</label>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Aktivitas & Pengalaman --}}
                        <div class="section-title mt-4 mb-3 fw-bold text-primary border-bottom pb-2">4. Aktivitas &
                            Pengalaman</div>

                        <div class="form-group mb-3">
                            <label class="form-label">Frekuensi Olahraga (per Minggu)</label>
                            <select name="frekuensi_olahraga" class="form-select" required>
                                <option value="" disabled selected>Pilih frekuensi...</option>
                                <option value="0x (Jarang sekali)">0x (Jarang sekali / Pemula)</option>
                                <option value="1-2x (Kadang-kadang)">1-2x (Kadang-kadang)</option>
                                <option value="3x atau lebih (Rutin)">3x atau lebih (Rutin / Aktif)</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Pengalaman Gym / Alat Fitness</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pengalaman_gym" value="Belum Pernah"
                                    id="exp_new" required>
                                <label class="form-check-label" for="exp_new">Belum Pernah (Butuh Bimbingan
                                    Full)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pengalaman_gym"
                                    value="Pernah (Dulu), Sekarang Lupa" id="exp_mid">
                                <label class="form-check-label" for="exp_mid">Pernah (Dulu), Sekarang Lupa
                                    Teknik</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pengalaman_gym"
                                    value="Rutin / Paham Teknik" id="exp_pro">
                                <label class="form-check-label" for="exp_pro">Rutin / Paham Teknik Dasar</label>
                            </div>
                        </div>

                        {{-- 5. Gaya Hidup & Tujuan --}}
                        <div class="section-title mt-4 mb-3 fw-bold text-primary border-bottom pb-2">5. Gaya Hidup &
                            Tujuan</div>

                        <div class="form-group mb-3">
                            <label class="form-label">Pola Makan Saat Ini</label>
                            <select name="pola_makan" class="form-select" required>
                                <option value="" disabled selected>Pilih pola makan...</option>
                                <option value="Berantakan">Berantakan (Suka gorengan/manis/tidak teratur)</option>
                                <option value="Lumayan">Lumayan (Cukup sehat tapi belum ketat)</option>
                                <option value="Ketat">Ketat (Sudah menimbang makanan/diet khusus)</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Target Utama Kamu</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check card p-2 border">
                                    <input class="form-check-input ms-1" type="radio" name="target_utama"
                                        value="Fat Loss" id="goal_fat" required>
                                    <label class="form-check-label ms-2 fw-bold" for="goal_fat">Turun Berat Badan (Fat
                                        Loss)</label>
                                </div>
                                <div class="form-check card p-2 border">
                                    <input class="form-check-input ms-1" type="radio" name="target_utama"
                                        value="Muscle Gain" id="goal_muscle">
                                    <label class="form-check-label ms-2 fw-bold" for="goal_muscle">Badan Berotot (Muscle
                                        Gain)</label>
                                </div>
                                <div class="form-check card p-2 border">
                                    <input class="form-check-input ms-1" type="radio" name="target_utama"
                                        value="Performa" id="goal_sport">
                                    <label class="form-check-label ms-2 fw-bold" for="goal_sport">Peningkatan Performa
                                        (Lari/Atlet)</label>
                                </div>
                                <div class="form-check card p-2 border">
                                    <input class="form-check-input ms-1" type="radio" name="target_utama"
                                        value="Sehat & Bugar" id="goal_health">
                                    <label class="form-check-label ms-2 fw-bold" for="goal_health">Sehat & Bugar Saja
                                        (Maintenance)</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Keluhan Spesifik / Tambahan (Opsional)</label>
                            <textarea name="keluhan" class="form-control" rows="3"
                                placeholder="Contoh: Saya sering sakit pinggang kalau duduk lama..."></textarea>
                        </div>

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold">
                                <i class="fas fa-search me-2"></i> ANALISA SAYA SEKARANG
                            </button>
                            <p class="text-muted small mt-2">Data Anda aman dan hanya digunakan untuk rekomendasi
                                program.</p>
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

    @push('scripts')
        <script>
            function toggleMedis(source) {
                const checkboxes = document.querySelectorAll('.medis-item');
                if (source.checked) {
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                        cb.disabled = true;
                    });
                } else {
                    checkboxes.forEach(cb => {
                        cb.disabled = false;
                    });
                }
            }

            // Loading Handler
            document.querySelector('form').addEventListener('submit', function () {
                document.getElementById('loadingOverlay').style.display = 'flex';
                this.querySelector('button[type="submit"]').disabled = true;
            });
        </script>
    @endpush
</x-app-layout>