<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $customSlugs = [
            "Men's Clothing"          => "mens_clothing",
            "Women's Clothing"        => "womens_clothing",
            "Toys & Baby"             => "toys_baby",
            "Sports & Outdoors"       => "sports_outdoors",
            "Motorcycle Parts"        => "motorcycle_parts",
            "Pet Accessories"         => "pet_accessories",
            "Medical Devices"         => "medical_devices",
            "Office Supplies"         => "office_supplies",
            "Outdoor Gear"            => "outdoor_gear",
            "Personal Care"           => "personal_care",
            "Mobile Phones"           => "mobile_phones",
            "Beauty & Personal Care"  => "personal_care",
            "Audio Gear"              => "audio_gear",
            "Smart Home"              => "smart_home",
        ];

        $filePath = 'product_images.json';
        if (!Storage::disk('local')->exists($filePath)) {
            $this->command->error("File not found: " . $filePath);
            return;
        }

        $productImages = json_decode(Storage::disk('local')->get($filePath), true);

        $sellers = Seller::all();
        $categories = Category::doesntHave('children')->get();

        if ($sellers->isEmpty() || $categories->isEmpty()) {
            $this->command->error("Seed sellers and categories first!");
            return;
        }

        $specExample = ['weight' => '1kg', 'color' => 'Black', 'material' => 'Mixed'];

        foreach ($categories as $category) {
            $categorySlug = $customSlugs[$category->name] ?? Str::slug($category->name, '_');

            if (!isset($productImages[$categorySlug]) || empty($productImages[$categorySlug])) {
                $this->command->warn("Missing images for: $categorySlug. Skipping...");
                continue; 
            }

            // Create 3 demo products per category
            for ($i = 0; $i < 3; $i++) {
                $imagesForCategory = $productImages[$categorySlug];
                shuffle($imagesForCategory);
                
                $galleryArr = array_slice($imagesForCategory, 0, 4);
                $mainImage = $galleryArr[0];

                $productName = 'Demo ' . $category->name . ' Product ' . Str::upper(Str::random(3));

                Product::create([
                    'seller_id'         => $sellers->random()->id, // Assign to random seller
                    'category_id'       => $category->id,
                    'name'              => $productName,
                    'slug'              => Str::slug($productName . '-' . Str::random(2)),
                    'description'       => "High-quality sample product for the {$category->name} category.",
                    'short_description' => "Affordable and popular $productName.",
                    'price'             => rand(100, 500),
                    'compare_price'     => rand(501, 999),
                    'sale_price'        => rand(0, 1) ? rand(50, 80) : null,
                    'sku'               => strtoupper('SKU-' . Str::random(8)),
                    'stock_quantity'    => rand(10, 100),
                    'image'             => $mainImage,
                    'gallery'           => $galleryArr, // No json_encode needed due to Model Casting
                    'specifications'    => $specExample, // No json_encode needed
                    'is_featured'       => (bool)rand(0, 1),
                    'is_active'         => true,
                    'on_sale'           => (bool)rand(0, 1),
                ]);
            }
        }
        
        $this->command->info("Product seeding completed!");
    }
}