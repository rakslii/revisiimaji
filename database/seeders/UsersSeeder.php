<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin User
            [
                'name' => 'Administrator',
                'email' => 'admin@ciptaimaji.com',
                'phone' => '6281122334455',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Admin+Cipta&background=3B82F6&color=fff',
            ],
            
            // Staff User
            [
                'name' => 'Staff Operasional',
                'email' => 'staff@ciptaimaji.com',
                'phone' => '6281234567890',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Staff+Ops&background=10B981&color=fff',
            ],
            
            // Customer Users
            [
                'name' => 'Budi Santoso',
                'email' => 'customer@example.com',
                'phone' => '6289876543210',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=8B5CF6&color=fff',
            ],
            [
                'name' => 'Sari Wijaya',
                'email' => 'sari.wijaya@email.com',
                'phone' => '6287654321098',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Sari+Wijaya&background=EC4899&color=fff',
            ],
            [
                'name' => 'Ahmad Fauzan',
                'email' => 'ahmad.fauzan@email.com',
                'phone' => '6281122334455',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Fauzan&background=F59E0B&color=fff',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('👑 Admin: admin@ciptaimaji.com / password');
        $this->command->info('👨‍💼 Staff: staff@ciptaimaji.com / password');
        $this->command->info('👤 Customer: customer@example.com / password');
    }
}