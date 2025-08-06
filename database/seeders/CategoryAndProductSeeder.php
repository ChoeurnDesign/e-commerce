<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CategoryAndProductSeeder extends Seeder
{
    public function run()
    {
        // Ensure all categories use valid, working image URLs.
        $categoryImages = [
            'Electronics'    => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?fit=crop&w=400&q=80',
            'Fashion'        => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?fit=crop&w=400&q=80',
            'Home & Garden' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?fit=crop&w=400&q=80',
'Sports' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?fit=crop&w=400&q=80',
            'Books'          => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?fit=crop&w=400&q=80',
        ];

        $subcategoryImages = [
            'Smartphones'    => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?fit=crop&w=400&q=80',
            'Laptops'        => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?fit=crop&w=400&q=80',
            'Headphones'     => 'https://images.unsplash.com/photo-1511367461989-f85a21fda167?fit=crop&w=400&q=80',
            'Men'            => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=400&q=80',
            'Women'          => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?fit=crop&w=400&q=80',
            'Accessories'    => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?fit=crop&w=400&q=80',
            'Furniture'      => 'https://images.unsplash.com/photo-1449247613801-ab06418e2861?fit=crop&w=400&q=80',
            'Kitchen' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?fit=crop&w=400&q=80',
            'Team Sports' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?fit=crop&w=400&q=80',
            'Garden'         => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?fit=crop&w=400&q=80',
            'Fiction'        => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?fit=crop&w=400&q=80',
            'Non-fiction'    => 'https://images.unsplash.com/photo-1513258496099-48168024aec0?fit=crop&w=400&q=80',
            'Comics'         => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?fit=crop&w=400&q=80',
            'Fitness'        => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?fit=crop&w=400&q=80',
            'Outdoor'        => 'https://images.unsplash.com/photo-1508780709619-79562169bc64?fit=crop&w=400&q=80',
        ];

        // Multiple images per subcategory for variety
        $productImages = [
            'Smartphones' => [
                'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?fit=crop&w=400&q=80',
            ],
            'Laptops' => [
                'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1513258496099-48168024aec0?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1509395176047-4a66953fd231?fit=crop&w=400&q=80',
            ],
            'Headphones' => [
                'https://images.unsplash.com/photo-1511367461989-f85a21fda167?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101178521-1e289f53b6e9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101054587-7443036b6a71?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?fit=crop&w=400&q=80',
            ],
            'Men' => [
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?fit=crop&w=400&q=80',
            ],
            'Women' => [
                'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?fit=crop&w=400&q=80',
            ],
            'Accessories' => [
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?fit=crop&w=400&q=80',
            ],
            'Furniture' => [
                'https://images.unsplash.com/photo-1449247613801-ab06418e2861?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?fit=crop&w=400&q=80',
            ],
            'Kitchen' => [
                'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1464983953574-0892a716854b?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?fit=crop&w=400&q=80',
            ],
            'Garden' => [
                'https://images.unsplash.com/photo-1464983953574-0892a716854b?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101178521-1e289f53b6e9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1513258496099-48168024aec0?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1508780709619-79562169bc64?fit=crop&w=400&q=80',
            ],
            'Fiction' => [
                'https://images.unsplash.com/photo-1516979187457-637abb4f9353?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101054587-7443036b6a71?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1512820790803-83ca734da794?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?fit=crop&w=400&q=80',
            ],
            'Non-fiction' => [
                'https://images.unsplash.com/photo-1513258496099-48168024aec0?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1516979187457-637abb4f9353?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?fit=crop&w=400&q=80',
            ],
            'Comics' => [
                'https://images.unsplash.com/photo-1507842217343-583bb7270b66?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1512820790803-83ca734da794?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?fit=crop&w=400&q=80',
            ],
            'Fitness' => [
                'https://images.unsplash.com/photo-1517649763962-0c623066013b?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?fit=crop&w=400&q=80',
            ],
            'Team Sports' => [
                'https://images.unsplash.com/photo-1505843279827-4e8dbe3c4b20?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1517649763962-0c623066013b?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1508780709619-79562169bc64?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1465101054587-7443036b6a71?fit=crop&w=400&q=80',
            ],
            'Outdoor' => [
                'https://images.unsplash.com/photo-1508780709619-79562169bc64?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1464983953574-0892a716854b?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1513258496099-48168024aec0?fit=crop&w=400&q=80',
            ],
        ];

        // Fresh seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Electronics' => ['Smartphones', 'Laptops', 'Headphones'],
            'Fashion' => ['Men', 'Women', 'Accessories'],
            'Home & Garden' => ['Furniture', 'Kitchen', 'Garden'],
            'Books' => ['Fiction', 'Non-fiction', 'Comics'],
            'Sports' => ['Fitness', 'Team Sports', 'Outdoor'],
        ];

        $subcategoryIds = [];

        // Create categories and subcategories with images
        foreach ($categories as $catName => $subcats) {
            $category = Category::create([
                'name'        => $catName,
                'slug'        => Str::slug($catName),
                'image'       => $categoryImages[$catName],
                'description' => "Explore our $catName category for the best items.",
            ]);
            foreach ($subcats as $subcat) {
                $subCategory = Category::create([
                    'name'        => $subcat,
                    'slug'        => Str::slug($subcat),
                    'image'       => $subcategoryImages[$subcat],
                    'parent_id'   => $category->id,
                    'description' => "Shop high quality $subcat.",
                ]);
                $subcategoryIds[$subcat] = $subCategory->id;
            }
        }

        // Create products for each subcategory with varied images
        foreach ($subcategoryIds as $subcat => $catId) {
            $images = $productImages[$subcat];
            $numImages = count($images);
            for ($i = 1; $i <= 8; $i++) {
                $baseName = $subcat . ' Product ' . $i;
                Product::create([
                    'name'             => $baseName,
                    'slug'             => Str::slug($baseName . '-' . $i),
                    'description'      => "This is a great $subcat product. It has all the features you need.",
                    'short_description' => "Top $subcat item, model $i.",
                    'price'            => rand(40, 600),
                    'compare_price'    => rand(60, 800),
                    'sale_price'       => rand(0, 1) ? rand(30, 500) : null,
                    'sku'              => strtoupper(Str::random(8)),
                    'stock_quantity'   => rand(2, 30),
                    'image'            => $images[($i - 1) % $numImages],
                    'images'           => json_encode([
                        $images[($i - 1) % $numImages]
                    ]),
                    'specifications'   => json_encode(['Color' => 'Random', 'Warranty' => '1 year']),
                    'gallery'          => json_encode([
                        $images[($i - 1) % $numImages]
                    ]),
                    'is_featured'      => rand(0, 1),
                    'is_active'        => true,
                    'category_id'      => $catId,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
