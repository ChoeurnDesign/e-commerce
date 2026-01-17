<?php

namespace Database\Seeders;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CategoryImageSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ReviewSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Use only the new combined seeder for categories and products
            CategorySeeder::class,
            AdminUserSeeder::class,
            ReviewSeeder::class,
            SellerSeeder::class,
            ProductSeeder::class,
        ]);
    }
}