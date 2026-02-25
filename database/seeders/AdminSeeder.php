<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama (Sesuai Request)
        User::updateOrCreate(
            ['email' => 'adminmindfitindonesia@gmail.com'],
            [
                'name' => 'Admin Mindfit',
                'password' => Hash::make('Bismillahmindfitsukses123$'),
                'role' => 'admin',
                'is_premium' => true, // Admin biasanya tidak butuh premium, tapi tidak masalah
            ]
        );

        // 2. Akun Admin Kedua (Sesuai Arahan "Sesuaikan Aja")
        User::updateOrCreate(
            ['email' => 'superadmin@mindfitindonesia.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Bismillahmindfitsukses123$'),
                'role' => 'admin',
                'is_premium' => true,
            ]
        );
    }
}
