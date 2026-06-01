<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds in the correct dependency order.
     *
     * To reset and seed from scratch:
     *   php artisan migrate:fresh --seed
     *
     * To only re-seed (preserves schema):
     *   php artisan db:seed
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('====================================================');
        $this->command->info('       SHOPEXPRESS DEMO DATA SEEDER');
        $this->command->info('====================================================');
        $this->command->newLine();

        $this->call([
            // 1. Foundation (no dependencies)
            CurrencySeeder::class,
            DemoSettingSeeder::class,
            DemoCategorySeeder::class,

            // 2. Users (admin, sellers, customers)
            DemoUserSeeder::class,

            // 3. Products (depends on categories + sellers)
            DemoProductSeeder::class,

            // 4. Marketing
            DemoCouponSeeder::class,

            // 5. Activity (depends on users + products)
            DemoReviewSeeder::class,
            DemoOrderSeeder::class,

            // 6. Returns + payouts (depend on orders)
            DemoReturnSeeder::class,
            DemoPayoutSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('====================================================');
        $this->command->info('   SEEDING COMPLETE!');
        $this->command->info('');
        $this->command->info('   Login at: http://localhost:8000/login');
        $this->command->info('');
        $this->command->info('   Admin:    admin@shop.com    / password');
        $this->command->info('   Seller:   seller@shop.com   / password');
        $this->command->info('   Customer: customer@shop.com / password');
        $this->command->info('====================================================');
        $this->command->newLine();
    }
}
