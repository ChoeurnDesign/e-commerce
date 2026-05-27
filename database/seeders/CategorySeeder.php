<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Load category structure from categories.json
        $jsonPath = storage_path('app/private/categories.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("JSON file not found at: " . $jsonPath);
            return;
        }
        $categories = json_decode(file_get_contents($jsonPath), true);

        // Load images from category_images.json
        $imageJsonPath = storage_path('app/private/category_images.json');
        if (!file_exists($imageJsonPath)) {
            $this->command->error("category_images.json not found at: " . $imageJsonPath);
            return;
        }
        $categoryImages = json_decode(file_get_contents($imageJsonPath), true);

        foreach ($categories as $topName => $subs) {
            $topSlug = Str::slug($topName, '_');
            $topImage = $categoryImages[$topSlug]
                ?? "https://ui-avatars.com/api/?name=" . urlencode($topName);

            $topId = DB::table('categories')->insertGetId([
                'name'        => $topName,
                'slug'        => $topSlug,
                'parent_id'   => null,
                'is_active'   => true,
                'description' => "Explore our range of $topName",
                'image'       => $topImage,
                'created_at'  => $now,
                'updated_at'  => $now
            ]);

            foreach ($subs as $subName) {
                $subSlug = Str::slug($subName, '_');
                $subImage = $categoryImages[$subSlug]
                    ?? "https://ui-avatars.com/api/?name=" . urlencode($subName);

                DB::table('categories')->insert([
                    'name'        => $subName,
                    'slug'        => $subSlug,
                    'parent_id'   => $topId,
                    'is_active'   => true,
                    'description' => "$subName products in $topName",
                    'image'       => $subImage,
                    'created_at'  => $now,
                    'updated_at'  => $now
                ]);
            }
        }

        $this->command->info('CategorySeeder: Static image mapping applied!');
    }
}