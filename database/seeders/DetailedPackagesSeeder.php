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
            // 1. MINDFIT PRIVATE CLASS (1 ON 1)
            // ==================================================================================
            [
                'name' => '[Private] 1-ON-1 (4 Sesi)',
                'type' => 'fitness',
                'price' => 799400,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Private Personal Trainer</strong></p>
                    <ul>
                        <li>Total Sesi: 4 Sesi Per Bulan</li>
                        <li>Harga Per Sesi: Rp 199.850</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Eksklusif: 1 Klien, 1 Coach</li>
                    </ul>
                '
            ],
            [
                'name' => '[Private] 1-ON-1 (8 Sesi)',
                'type' => 'fitness',
                'price' => 1518800,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Private Personal Trainer</strong></p>
                    <ul>
                        <li>Total Sesi: 8 Sesi Per Bulan</li>
                        <li>Harga Per Sesi: Rp 189.850</li>
                        <li>Masa Aktif: 1 Bulan</li>
                        <li>Eksklusif: 1 Klien, 1 Coach</li>
                    </ul>
                '
            ],
            [
                'name' => '[Private] 1-ON-1 (12 Sesi)',
                'type' => 'fitness',
                'price' => 2158200,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Private Personal Trainer</strong></p>
                    <ul>
                        <li>Total Sesi: 12 Sesi</li>
                        <li>Harga Per Sesi: Rp 179.850</li>
                        <li>Masa Aktif: 45 Hari (1.5 Bulan)</li>
                        <li>Eksklusif: 1 Klien, 1 Coach</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 2. MINDFIT GROUP (SQUAD) - 2 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 2 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 599700,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (2 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 1.199.400)</li>
                        <li>Harga Per Sesi (Total): Rp 299.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 149.925</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 2 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 1139400,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (2 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 2.278.800)</li>
                        <li>Harga Per Sesi (Total): Rp 284.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 142.425</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 2 Pax (12 Sesi)',
                'type' => 'fitness',
                'price' => 1619100,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Grup (2 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 3.238.200)</li>
                        <li>Harga Per Sesi (Total): Rp 269.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 134.925</li>
                        <li>Masa Aktif: 45 Hari</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 3. MINDFIT GROUP (SQUAD) - 4 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 4 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 299850,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (4 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 1.199.400)</li>
                        <li>Harga Per Sesi (Total): Rp 299.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 74.962</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 4 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 569700,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (4 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 2.278.800)</li>
                        <li>Harga Per Sesi (Total): Rp 284.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 71.212</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 4 Pax (12 Sesi)',
                'type' => 'fitness',
                'price' => 809550,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Grup (4 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 3.238.200)</li>
                        <li>Harga Per Sesi (Total): Rp 269.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 67.462</li>
                        <li>Masa Aktif: 45 Hari</li>
                    </ul>
                '
            ],

            // ==================================================================================
            // 4. MINDFIT GROUP (SQUAD) - 6 ORANG
            // ==================================================================================
            [
                'name' => '[Group] Squad 6 Pax (4 Sesi)',
                'type' => 'fitness',
                'price' => 333233,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (6 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 1.999.400)</li>
                        <li>Harga Per Sesi (Total): Rp 499.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 83.308</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 6 Pax (8 Sesi)',
                'type' => 'fitness',
                'price' => 643800,
                'duration_days' => 30,
                'description' => '
                    <p><strong>Paket Grup (6 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 3.862.800)</li>
                        <li>Harga Per Sesi (Total): Rp 482.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 80.475</li>
                        <li>Masa Aktif: 1 Bulan</li>
                    </ul>
                '
            ],
            [
                'name' => '[Group] Squad 6 Pax (12 Sesi)',
                'type' => 'fitness',
                'price' => 927700,
                'duration_days' => 45,
                'description' => '
                    <p><strong>Paket Grup (6 Orang)</strong></p>
                    <ul>
                        <li><strong>Catatan: Harga tertera adalah per orang</strong> (Total Grup: Rp 5.566.200)</li>
                        <li>Harga Per Sesi (Total): Rp 463.850</li>
                        <li>Harga Per Sesi (Per Orang): Rp 77.308</li>
                        <li>Masa Aktif: 45 Hari</li>
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
