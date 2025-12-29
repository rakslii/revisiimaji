<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Cipta Imaji',
            'email' => 'admin@ciptaimaji.com',
            'password' => Hash::make('admin123'),
            'google_id' => null,
            'avatar' => null,
            'email_verified_at' => now(),
        ]);

        // Tambah user dummy untuk testing
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'google_id' => 'test-google-id-123',
            'avatar' => 'https://ui-avatars.com/api/?name=Customer+Test',
            'email_verified_at' => now(),
        ]);
    }
}