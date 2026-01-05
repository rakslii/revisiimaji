<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Super Admin
        User::create([
            'name' => 'Super Admin Cipta Imaji',
            'email' => 'superadmin@ciptaimaji.com',
            'password' => Hash::make('SuperAdmin123!'),
            'role' => 'admin', // ✅ TAMBAHKAN ROLE
            'google_id' => null,
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 123, Bandung',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
            'postal_code' => '40123',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);

        // Buat Admin biasa
        User::create([
            'name' => 'Admin Cipta Imaji',
            'email' => 'admin@ciptaimaji.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin', // ✅ TAMBAHKAN ROLE
            'google_id' => null,
            'phone' => '081298765432',
            'address' => 'Jl. Contoh No. 456, Jakarta',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '10110',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);

        // Customer Test
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer', // ✅ DEFAULT 'customer'
            'google_id' => 'test-google-id-123',
            'phone' => '081511223344',
            'address' => 'Jl. Pelanggan No. 789',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'postal_code' => '60271',
            'avatar' => 'https://ui-avatars.com/api/?name=Customer+Test',
            'email_verified_at' => now(),
        ]);

        // Customer Jane
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('Jane123!'),
            'role' => 'customer',
            'google_id' => null,
            'phone' => '081522334455',
            'city' => 'Medan',
            'province' => 'Sumatera Utara',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Admin users seeded successfully!');
        $this->command->info('📧 Super Admin: superadmin@ciptaimaji.com / SuperAdmin123!');
        $this->command->info('📧 Admin: admin@ciptaimaji.com / admin123');
        $this->command->info('📧 Customer: customer@test.com / password');
    }
}