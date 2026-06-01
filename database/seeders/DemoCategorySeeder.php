<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds categories with realistic commission rates per industry.
 * Maps to DummyJSON product categories for clean product seeding.
 */
class DemoCategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo categories with commission rates...');

        // Industry-standard commission rates from real platforms (Shopee/Lazada/Amazon)
        $categories = [
            // [slug, name, commission %, description]
            ['smartphones',        'Smartphones',        6.00, 'Latest mobile phones from top brands'],
            ['laptops',            'Laptops',            5.00, 'Notebooks for work, gaming, and creators'],
            ['tablets',            'Tablets',            6.00, 'iPads, Android tablets, drawing tablets'],
            ['mobile-accessories', 'Mobile Accessories', 12.00, 'Cases, chargers, screen protectors'],
            ['mens-watches',       "Men's Watches",      15.00, 'Smartwatches and traditional watches for men'],
            ['womens-watches',     "Women's Watches",    15.00, 'Smartwatches and traditional watches for women'],
            ['mens-shoes',         "Men's Shoes",        12.00, 'Sneakers, formal shoes, sports footwear'],
            ['womens-shoes',       "Women's Shoes",      12.00, 'Heels, sneakers, boots, sandals'],
            ['mens-shirts',        "Men's Shirts",       14.00, 'Casual, formal, and t-shirts for men'],
            ['womens-dresses',     "Women's Dresses",    14.00, 'Casual, party, and formal dresses'],
            ['womens-bags',        "Women's Bags",       15.00, 'Handbags, totes, clutches'],
            ['womens-jewellery',   "Women's Jewellery",  18.00, 'Necklaces, earrings, rings'],
            ['fragrances',         'Fragrances',         16.00, 'Perfumes and colognes from luxury brands'],
            ['skincare',           'Skincare',           15.00, 'Skincare and beauty products'],
            ['home-decoration',    'Home Decoration',    12.00, 'Decor, lighting, accessories for your home'],
            ['furniture',          'Furniture',          10.00, 'Indoor and outdoor furniture'],
            ['groceries',          'Groceries',          8.00, 'Fresh produce, packaged foods, beverages'],
            ['automotive',         'Automotive',         10.00, 'Car accessories, parts, tools'],
            ['motorcycle',         'Motorcycle',         10.00, 'Motorcycle gear and accessories'],
            ['lighting',           'Lighting',           12.00, 'Indoor and outdoor lighting solutions'],
        ];

        foreach ($categories as $idx => [$slug, $name, $rate, $desc]) {
            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'            => $name,
                    'description'     => $desc,
                    'sort_order'      => $idx,
                    'is_active'       => true,
                    'commission_rate' => $rate,
                ]
            );
        }

        $this->command->info("  ✓ " . count($categories) . " categories created with commission rates");
        $this->command->info("    (Smartphones 6%, Laptops 5%, Watches 15%, Jewellery 18%, etc.)");
    }
}
