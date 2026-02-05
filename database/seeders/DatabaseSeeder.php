<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSettingsSeeder::class,
            UsersSeeder::class,
            ProductCategoriesSeeder::class,
            ProductsSeeder::class,
            PromoCodesSeeder::class,
            AboutUsSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('👤 Admin Login: admin@ciptaimaji.com | Password: password');
        $this->command->info('👤 Customer Login: customer@example.com | Password: password');
    }
}
