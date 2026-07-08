<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing coaches to prevent duplicate/mixed records
        User::where('role', 'coach')->delete();

        // 1. Seed Personal Trainers (PT) - Fitness Specialization
        $pts = [
            [
                'name' => 'Coach Rafaeldo',
                'email' => 'coach.rafaeldo@mindfit.com',
                'phone' => '081122334401',
            ],
            [
                'name' => 'Coach Bilal',
                'email' => 'coach.bilal@mindfit.com',
                'phone' => '081122334402',
            ],
            [
                'name' => 'Coach Julian',
                'email' => 'coach.julian@mindfit.com',
                'phone' => '081122334403',
            ],
            [
                'name' => 'Coach Maylvie',
                'email' => 'coach.maylvie@mindfit.com',
                'phone' => '081122334404',
            ],
        ];

        foreach ($pts as $pt) {
            User::create([
                'name' => $pt['name'],
                'email' => $pt['email'],
                'password' => Hash::make('password123'),
                'phone' => $pt['phone'],
                'role' => 'coach',
                'specialization' => 'fitness',
                'avatar' => null,
                'is_premium' => false,
                'is_active' => true,
            ]);
        }

        // 2. Seed Nutritionists
        $nutritionists = [
            [
                'name' => 'dr. Muhammad Fahri Firdaus, Sp.Gk., M.H.',
                'email' => 'nutri.fahri@mindfit.com',
                'phone' => '082233445501',
            ],
            [
                'name' => 'dr. Naela Fadhila, M.Kes',
                'email' => 'nutri.naela@mindfit.com',
                'phone' => '082233445502',
            ],
            [
                'name' => 'Bela Prasasti, S.Gz',
                'email' => 'nutri.bela@mindfit.com',
                'phone' => '082233445503',
            ],
            [
                'name' => 'Ali Mahfudz Al Fawaz, S.Gz',
                'email' => 'nutri.ali@mindfit.com',
                'phone' => '082233445504',
            ],
        ];

        foreach ($nutritionists as $nutri) {
            User::create([
                'name' => $nutri['name'],
                'email' => $nutri['email'],
                'password' => Hash::make('password123'),
                'phone' => $nutri['phone'],
                'role' => 'coach',
                'specialization' => 'nutritionist',
                'avatar' => null,
                'is_premium' => false,
                'is_active' => true,
            ]);
        }
    }
}
