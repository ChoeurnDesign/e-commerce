<?php

namespace Database\Seeders;
use Database\Seeders\CategoryAndProductSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ReviewSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Use only the new combined seeder for categories and products
            CategoryAndProductSeeder::class,
            AdminUserSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
