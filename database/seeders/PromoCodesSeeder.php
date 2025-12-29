<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromoCodesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $promoCodes = [
            [
                'code' => 'WELCOME20',
                'name' => 'Welcome Discount 20%',
                'type' => 'percentage',
                'value' => 20.00,
                'quota' => 100,
                'used_count' => 25,
                'min_purchase' => 100000.00,
                'valid_from' => $now->copy()->subDays(30),
                'valid_until' => $now->copy()->addDays(60),
                'is_active' => true,
            ],
            [
                'code' => 'GRATISONGKIR',
                'name' => 'Free Shipping',
                'type' => 'nominal',
                'value' => 20000.00,
                'quota' => 200,
                'used_count' => 89,
                'min_purchase' => 150000.00,
                'valid_from' => $now->copy()->subDays(15),
                'valid_until' => $now->copy()->addDays(45),
                'is_active' => true,
            ],
            [
                'code' => 'RAMADHAN25',
                'name' => 'Ramadhan Sale 25%',
                'type' => 'percentage',
                'value' => 25.00,
                'quota' => 50,
                'used_count' => 12,
                'min_purchase' => 200000.00,
                'valid_from' => $now->copy()->subDays(10),
                'valid_until' => $now->copy()->addDays(20),
                'is_active' => true,
            ],
            [
                'code' => 'INSTAN15',
                'name' => 'Instant Product Discount 15%',
                'type' => 'percentage',
                'value' => 15.00,
                'quota' => 150,
                'used_count' => 47,
                'min_purchase' => 75000.00,
                'valid_from' => $now->copy()->subDays(7),
                'valid_until' => $now->copy()->addDays(30),
                'is_active' => true,
            ],
        ];

        foreach ($promoCodes as $promo) {
            DB::table('promo_codes')->updateOrInsert(
                ['code' => $promo['code']],
                $promo
            );
        }

        $this->command->info('✅ Promo codes seeded successfully!');
    }
}