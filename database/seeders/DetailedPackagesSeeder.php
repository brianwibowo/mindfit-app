<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Package;

class DetailedPackagesSeeder extends Seeder
{
    public function run()
    {
        // Disable existing packages instead of deleting to preserve history if any
        Package::query()->update(['is_active' => false]);

        $packages = [
            // ==================================================================================
            // 1. MINDFIT PRIVATE CLASS (STARTER EVOLVE)
            // ==================================================================================
            [
                'name' => '[Private] STARTER BASIC',
                'type' => 'fitness',
                'price' => 450000,
                'duration_days' => 30,
                'description' => '
                    <table class="table table-bordered table-sm text-start">
                        <tr><th width="35%">Target</th><td>Pemula (Adaptasi)</td></tr>
                        <tr><th>Frekuensi</th><td>4 Sesi / bulan (1x seminggu)</td></tr>
                        <tr><th>Durasi</th><td>45–60 Menit</td></tr>
                        <tr><th>Tipe Latihan</th><td>Full Body (Adaptasi Ringan)</td></tr>
                        <tr><th>Goal Utama</th><td>Bangun Kebiasaan (Habit)</td></tr>
                        <tr><th>Nutrisi</th><td>Estimasi Kalori Dasar</td></tr>
                        <tr><th>Monitoring</th><td>Saat sesi latihan</td></tr>
                        <tr><th>Mode</th><td>Online / Offline Gym</td></tr>
                    </table>
                '
            ],
            [
                'name' => '[Private] STARTER PLUS',
                'type' => 'fitness',
                'price' => 850000,
                'duration_days' => 30,
                'description' => '
                    <table class="table table-bordered table-sm text-start">
                        <tr><th width="35%">Target</th><td>Pemula</td></tr>
                        <tr><th>Frekuensi</th><td>8 Sesi / bulan (2x seminggu)</td></tr>
                        <tr><th>Durasi</th><td>60 Menit</td></tr>
                        <tr><th>Tipe Latihan</th><td>Full Body (Terstruktur)</td></tr>
                        <tr><th>Goal Utama</th><td>Fat Loss Awal & Stamina</td></tr>
                        <tr><th>Nutrisi</th><td>Rekomendasi Makro Simpel</td></tr>
                        <tr><th>Monitoring</th><td>Evaluasi Mingguan</td></tr>
                        <tr><th>Mode</th><td>Online / Offline / Home Visit*</td></tr>
                    </table>
                '
            ],
            [
                'name' => '[Private] STARTER COMPLETE',
                'type' => 'fitness',
                'price' => 1250000,
                'duration_days' => 30,
                'description' => '
                    <table class="table table-bordered table-sm text-start">
                        <tr><th width="35%">Target</th><td>Overweight / Komitmen Tinggi</td></tr>
                        <tr><th>Frekuensi</th><td>12 Sesi / bulan (3x seminggu)</td></tr>
                        <tr><th>Durasi</th><td>60 Menit</td></tr>
                        <tr><th>Tipe Latihan</th><td>Full Body + Focus Area</td></tr>
                        <tr><th>Goal Utama</th><td>Fat Loss, Postur, & Strength</td></tr>
                        <tr><th>Nutrisi</th><td>Personal Meal Plan Harian</td></tr>
                        <tr><th>Monitoring</th><td>Full Monitoring</td></tr>
                        <tr><th>Mode</th><td>Online / Offline / Home Visit*</td></tr>
                    </table>
                '
            ],

            // ==================================================================================
            // 2. MINDFIT GROUP (SQUAD) - 2 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 2 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 350000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berdua (2 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 700.000</li>
                        <li>Harga Per Orang: Rp 350.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: -</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 2 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 650000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berdua (2 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 1.300.000</li>
                        <li>Harga Per Orang: Rp 650.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: Evaluasi Mingguan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 2 Pax (10 Sesi)',
                'type' => 'fitness',
                'price' => 750000,
                'duration_days' => 45, // 6 Minggu approx
                'description' => '
                    <p><strong>Paket Berdua (2 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 1.500.000</li>
                        <li>Harga Per Orang: Rp 750.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 6 Minggu</li>
                        <li>Bonus: Evaluasi Mingguan + Free 1x Body Assessment</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 2. MINDFIT GROUP (SQUAD) - 4 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 4 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 250000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berempat (4 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 1.000.000</li>
                        <li>Harga Per Orang: Rp 250.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: -</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 4 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 450000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berempat (4 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 1.800.000</li>
                        <li>Harga Per Orang: Rp 450.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: Grup WA Monitoring</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 4 Pax (10 Sesi)',
                'type' => 'fitness',
                'price' => 525000,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Berempat (4 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 2.100.000</li>
                        <li>Harga Per Orang: Rp 525.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 6 Minggu</li>
                        <li>Bonus: Grup WA Monitoring + Free Body Assessment</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 2. MINDFIT GROUP (SQUAD) - 6 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 6 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 200000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berenam (6 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 1.200.000</li>
                        <li>Harga Per Orang: Rp 200.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: -</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 6 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 350000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Berenam (6 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 2.100.000</li>
                        <li>Harga Per Orang: Rp 350.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Bonus: Grup WA Support</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 6 Pax (10 Sesi)',
                'type' => 'fitness',
                'price' => 400000,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Berenam (6 Orang)</strong></p>
                    <ul>
                        <li>Total Harga Grup: Rp 2.400.000</li>
                        <li>Harga Per Orang: Rp 400.000 (Yang dibayarkan saat ini)</li>
                        <li>Masa Aktif: 6 Minggu</li>
                        <li>Bonus: Prioritas Booking + Voucher Diskon + Body Assessment</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 3. MINDFIT ACADEMY (TEAMS)
            // ==================================================================================
            [
                'name' => '[Academy] STABLE PERFORMANCE',
                'type' => 'fitness',
                'price' => 4500000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Investasi Tim (Per Bulan)</strong> - Max 6 Atlet</p>
                    <ul>
                        <li>Maintenance Periodization</li>
                        <li>Corrective Exercise (Postur)</li>
                        <li>Injury Prevention Drills</li>
                        <li>1x Physical Test (Basic)</li>
                        <li>Group Nutrition Assessment</li>
                        <li>1x Sesi Edukasi Gizi</li>
                    </ul>
                '
            ],
            [
                'name' => '[Academy] HIGH PERFORMANCE',
                'type' => 'fitness',
                'price' => 7200000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Investasi Tim (Per Bulan)</strong> - Max 6 Atlet (Prestasi)</p>
                    <ul>
                        <li>Peaking Periodization (Power/Speed)</li>
                        <li>Sport Specific Agility</li>
                        <li>Pre & Post Physical Test (Lengkap)</li>
                        <li>Recovery Session</li>
                        <li>Personalized Meal Plan</li>
                        <li>Game Day Nutrition Strategy</li>
                        <li>Weekly Monitoring</li>
                    </ul>
                '
            ],
            [
                'name' => '[Academy] STANDARD CONSULTANT',
                'type' => 'fitness',
                'price' => 2500000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Fokus: Standarisasi Latihan</strong></p>
                    <ul>
                        <li>4x Kunjungan Fisik (Coach S&C Level 2)</li>
                        <li>Program Latihan Bulanan (PDF & Worksheet)</li>
                        <li>Supervisi Pelatih Klub</li>
                        <li>Tanpa Nutrisi Spesifik</li>
                    </ul>
                '
            ],
            [
                'name' => '[Academy] PRO CONSULTANT',
                'type' => 'fitness',
                'price' => 3500000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Fokus: High Performance</strong></p>
                    <ul>
                        <li>4x Kunjungan Fisik (Coach S&C Level 2)</li>
                        <li>1x Kunjungan Nutrisi (Edukasi & Menu Audit)</li>
                        <li>Program Latihan & Gizi Terintegrasi</li>
                        <li>Akses Konsultasi WA (Priority)</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 4. MINDFIT NUTRITIONIST
            // ==================================================================================
            [
                'name' => '[Nutrition] STARTER',
                'type' => 'nutrition',
                'price' => 650000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Fokus: Habit & Lifestyle</strong></p>
                    <ul>
                        <li>Target: Pemula / Umum</li>
                        <li>Konseling</li>
                        <li>Personalisasi Diet Programs</li>
                    </ul>
                '
            ],
            [
                'name' => '[Nutrition] TRANSFORMATION',
                'type' => 'nutrition',
                'price' => 680000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Fokus: Fat Loss & Body Comp</strong></p>
                    <ul>
                        <li>Target: Fitness Client / Umum</li>
                        <li>Assessment</li>
                        <li>Meal Plan</li>
                        <li>Basic Macro Nutritionist Education</li>
                    </ul>
                '
            ],
            [
                'name' => '[Nutrition] PERFORMANCE',
                'type' => 'nutrition',
                'price' => 680000,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Fokus: Performance & Recovery</strong></p>
                    <ul>
                        <li>Target: Advanced / Umum</li>
                        <li>Konseling & Assessment</li>
                        <li>Basic Macro Nutritionist Education</li>
                        <li>Personalisasi Diet Program</li>
                    </ul>
                '
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}
