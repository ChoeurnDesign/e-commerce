<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Idempotent seeder for the existing `categories` table.
     *
     * Behavior:
     * - Creates top-level and subcategories only if they don't already exist
     *   (compares case-insensitive name + parent).
     * - Generates a unique slug if needed (avoids collision with existing slugs).
     * - Does not overwrite existing records' name/description if they already exist.
     * - If an image file with a slug-based filename exists in
     *   database/seeders/assets/categories it will be copied to storage/app/public/categories
     *   and the category.image column will be set to "categories/<filename>" if image is empty.
     *
     * Note: Run on dev/staging automatically. For production run as a controlled step
     * after DB backup: php artisan db:seed --class=CategorySeeder
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Cameras', 'Wearables', 'Audio'],
            'Fashion' => ["Women's Clothing", "Men's Clothing", 'Shoes', 'Accessories'],
            'Home & Living' => ['Furniture', 'Home Decor', 'Kitchen & Dining', 'Bedding'],
            'Beauty & Personal Care' => ['Skincare', 'Haircare', 'Makeup', 'Fragrances'],
            'Health & Wellness' => ['Supplements', 'Personal Care', 'Medical Devices'],
            'Sports & Outdoors' => ['Fitness Equipment', 'Outdoor Gear', 'Bicycles', 'Sportswear'],
            'Toys & Baby' => ['Baby Gear', 'Educational Toys', 'Feeding & Nursing', 'Strollers'],
            'Grocery & Gourmet Food' => ['Pantry', 'Fresh Food', 'Beverages', 'Snacks'],
            'Automotive & Industrial' => ['Car Accessories', 'Tools', 'Motorcycle Parts', 'Industrial Supplies'],
            'Books, Music & Office' => ['Books', 'Stationery', 'Office Supplies', 'Musical Instruments'],
            'Pets' => ['Pet Food', 'Pet Accessories', 'Health & Grooming'],
            'Garden & DIY' => ['Gardening Tools', 'Plants', 'DIY Tools', 'Home Improvement'],
            'Jewelry & Watches' => ['Fine Jewelry', 'Costume Jewelry', 'Watches'],
            'Services & Digital Goods' => ['Gift Cards', 'Digital Downloads', 'Repair & Installation Services'],
        ];

        // Where to find seed assets inside the repo
        $assetsPath = database_path('seeders/assets/categories');

        DB::transaction(function () use ($categories, $now, $assetsPath) {
            foreach ($categories as $topName => $subs) {
                $topParentId = null;

                // Check existing top-level by case-insensitive name + parent_id IS NULL
                $existingTop = DB::table('categories')
                    ->whereRaw('LOWER(name) = ?', [mb_strtolower($topName)])
                    ->whereNull('parent_id')
                    ->first();

                if ($existingTop) {
                    $topParentId = $existingTop->id;
                } else {
                    // Create a unique slug and insert
                    $topSlug = $this->uniqueSlug($topName);
                    $topParentId = DB::table('categories')->insertGetId([
                        'parent_id'    => null,
                        'name'         => $topName,
                        'slug'         => $topSlug,
                        'description'  => $topName . ' products',
                        'image'        => null,
                        'is_active'    => 1,
                        'sort_order'   => 0,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }

                // Optionally set/copy top image if none exists
                $this->ensureCategoryImage($topParentId, $topName, null, $assetsPath);

                // Insert subcategories under the top-level
                foreach ($subs as $index => $subName) {
                    // Check existing by name and parent
                    $existingSub = DB::table('categories')
                        ->whereRaw('LOWER(name) = ?', [mb_strtolower($subName)])
                        ->where('parent_id', $topParentId)
                        ->first();

                    if ($existingSub) {
                        // ensure subcategory image exists if missing
                        $this->ensureCategoryImage($existingSub->id, $subName, $topName, $assetsPath);
                        continue;
                    }

                    // Create a unique slug for the subcategory
                    $subSlug = $this->uniqueSlug($subName);

                    $subId = DB::table('categories')->insertGetId([
                        'parent_id'    => $topParentId,
                        'name'         => $subName,
                        'slug'         => $subSlug,
                        'description'  => $subName . ' in ' . $topName,
                        'image'        => null,
                        'is_active'    => 1,
                        'sort_order'   => ($index + 1) * 10,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);

                    // Set/copy subcategory image if available
                    $this->ensureCategoryImage($subId, $subName, $topName, $assetsPath);
                }
            }
        });
    }

    /**
     * Generate a unique slug that does not collide with existing rows in `categories.slug`.
     * If a perfect slug already exists, append -1, -2, ... until unique.
     */
    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: Str::random(6);
        $slug = $base;
        $i = 1;

        while (DB::table('categories')->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Ensure category has an image; if the DB column is empty and a matching seed asset file exists,
     * copy it to storage/app/public/categories and set the image path on the record.
     *
     * File matching logic:
     * - First tries: slug-of-parent-if-present + '-' + slug-of-name + .(jpg|png|webp)
     * - Then tries: slug-of-name.(jpg|png|webp)
     */
    protected function ensureCategoryImage(int $categoryId, string $name, ?string $parentName, string $assetsPath): void
    {
        $category = DB::table('categories')->where('id', $categoryId)->first();
        if (!$category) {
            return;
        }

        // If image already set, do nothing (idempotent)
        if (!empty($category->image)) {
            return;
        }

        $candidates = [];

        if ($parentName) {
            $candidates[] = Str::slug($parentName) . '-' . Str::slug($name);
        }
        $candidates[] = Str::slug($name);

        $extensions = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($candidates as $candidateBase) {
            foreach ($extensions as $ext) {
                $filename = $candidateBase . '.' . $ext;
                $source = $assetsPath . DIRECTORY_SEPARATOR . $filename;
                if (file_exists($source)) {
                    // Ensure public disk has the folder
                    $destPath = 'categories/' . $filename;

                    // Copy the file to storage/app/public/categories (idempotent)
                    // If file already exists in storage, don't overwrite
                    if (!Storage::disk('public')->exists($destPath)) {
                        // Using File object to copy
                        Storage::disk('public')->putFileAs('categories', new File($source), $filename);
                    }

                    // Update record with the relative path used by storage disk
                    DB::table('categories')->where('id', $categoryId)->update([
                        'image' => $destPath,
                        'updated_at' => Carbon::now(),
                    ]);

                    return  ;
                }
            }
        }

        // No file found — do nothing. (You could set a default placeholder here if desired.)
    }
}