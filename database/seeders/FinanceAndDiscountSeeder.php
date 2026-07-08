<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use App\Models\Expense;
use Carbon\Carbon;

class FinanceAndDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Discounts
        Discount::updateOrCreate(
            ['code' => 'MINDFIT10'],
            [
                'type' => 'percent',
                'value' => 10,
                'max_limit' => 50000,
                'max_uses' => 10,
                'min_purchase' => 150000,
                'start_date' => Carbon::now()->subDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'MINDFIT20'],
            [
                'type' => 'percent',
                'value' => 20,
                'max_limit' => null,
                'max_uses' => 2,
                'min_purchase' => 300000,
                'start_date' => Carbon::now()->subDays(10)->toDateString(),
                'end_date' => Carbon::now()->addDays(60)->toDateString(),
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'PROMO50'],
            [
                'type' => 'percent',
                'value' => 50,
                'max_limit' => 100000,
                'max_uses' => 1,
                'min_purchase' => 500000,
                'start_date' => Carbon::now()->subDays(1)->toDateString(),
                'end_date' => Carbon::now()->addDays(7)->toDateString(),
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'KUSUS100K'],
            [
                'type' => 'nominal',
                'value' => 100000,
                'max_limit' => null,
                'max_uses' => 5,
                'min_purchase' => 200000,
                'start_date' => Carbon::now()->subDays(2)->toDateString(),
                'end_date' => Carbon::now()->addDays(15)->toDateString(),
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'EXPIRED'],
            [
                'type' => 'percent',
                'value' => 15,
                'max_limit' => null,
                'max_uses' => null,
                'min_purchase' => null,
                'start_date' => Carbon::now()->subDays(30)->toDateString(),
                'end_date' => Carbon::now()->subDays(1)->toDateString(),
                'is_active' => true, // expired by date range
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'NONAKTIF'],
            [
                'type' => 'percent',
                'value' => 25,
                'max_limit' => null,
                'max_uses' => null,
                'min_purchase' => null,
                'start_date' => Carbon::now()->subDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
                'is_active' => false,
            ]
        );

        // 2. Seed Expenses
        Expense::create([
            'description' => 'Sewa Ruko Cabang Sleman',
            'amount' => 5000000,
            'category' => 'Office Rent',
            'date' => Carbon::now()->subMonth()->startOfMonth()->toDateString(),
        ]);

        Expense::create([
            'description' => 'Gaji Coach Adrian',
            'amount' => 1500000,
            'category' => 'Coach Salary',
            'date' => Carbon::now()->subMonth()->startOfMonth()->addDays(24)->toDateString(),
        ]);

        Expense::create([
            'description' => 'Tagihan Listrik & Internet Juni',
            'amount' => 650000,
            'category' => 'Utilities',
            'date' => Carbon::now()->subDays(10)->toDateString(),
        ]);

        Expense::create([
            'description' => 'Pembelian Kettlebell 16kg & 20kg',
            'amount' => 780000,
            'category' => 'Equipment',
            'date' => Carbon::now()->subDays(4)->toDateString(),
        ]);

        Expense::create([
            'description' => 'Iklan Instagram Ads',
            'amount' => 450000,
            'category' => 'Marketing',
            'date' => Carbon::now()->subDays(1)->toDateString(),
        ]);
    }
}
