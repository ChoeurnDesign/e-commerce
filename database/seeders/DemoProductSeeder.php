<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Fetches real product data from DummyJSON (free, no API key) and creates
 * ~1,500 products by generating variants of the 194 base products,
 * distributed across the approved sellers.
 */
class DemoProductSeeder extends Seeder
{
    /**
     * Strategy: distribute unique products across sellers — NO fake variants.
     * Each base product from DummyJSON goes to ONE seller only.
     *
     * To boost realism with multi-seller products, a SMALL percentage
     * (multiSellerRatio) are listed by 2-3 sellers (common for electronics,
     * branded items) — but they keep the SAME name, not "- Premium" / "- Pro".
     */

    /** How many product listings to create in total. */
    protected int $targetTotal = 600;

    /** Fraction of base products that get listed by multiple sellers (0.0 to 1.0). */
    protected float $multiSellerRatio = 0.25;

    /** DummyJSON category slug → our category slug mapping */
    protected array $categoryMap = [
        'smartphones'           => 'smartphones',
        'laptops'               => 'laptops',
        'tablets'               => 'tablets',
        'mobile-accessories'    => 'mobile-accessories',
        'mens-watches'          => 'mens-watches',
        'womens-watches'        => 'womens-watches',
        'mens-shoes'            => 'mens-shoes',
        'womens-shoes'          => 'womens-shoes',
        'mens-shirts'           => 'mens-shirts',
        'womens-dresses'        => 'womens-dresses',
        'womens-bags'           => 'womens-bags',
        'womens-jewellery'      => 'womens-jewellery',
        'fragrances'            => 'fragrances',
        'skin-care'             => 'skincare',
        'home-decoration'       => 'home-decoration',
        'furniture'             => 'furniture',
        'groceries'             => 'groceries',
        'automotive'            => 'automotive',
        'motorcycle'            => 'motorcycle',
        'lighting'              => 'lighting',
        // Fallbacks for DummyJSON categories we don't have
        'beauty'                => 'skincare',
        'kitchen-accessories'   => 'home-decoration',
        'sunglasses'            => 'mobile-accessories',
        'sports-accessories'    => 'automotive',
        'tops'                  => 'mens-shirts',
        'vehicle'               => 'automotive',
    ];

    /** Variant naming suffixes for generating ~8 versions of each base product */
    protected array $variantSuffixes = [
        ' - Standard Edition',
        ' - Premium',
        ' - Pro',
        ' - Limited Edition',
        ' - 2024 Model',
        ' - Bundle Pack',
        ' - Refurbished',
        ' - International Version',
    ];

    public function run(): void
    {
        $this->command->info('Fetching real product data from DummyJSON…');

        // Fetch all 194 products in batches
        $allProducts = [];
        $skip = 0;
        $limit = 100;

        do {
            try {
                $response = Http::timeout(30)
                    ->get("https://dummyjson.com/products?limit={$limit}&skip={$skip}");

                if (!$response->successful()) {
                    $this->command->warn("  ⚠ DummyJSON fetch failed at skip={$skip}");
                    break;
                }

                $data = $response->json();
                $batch = $data['products'] ?? [];
                if (empty($batch)) break;

                $allProducts = array_merge($allProducts, $batch);
                $skip += $limit;
            } catch (\Throwable $e) {
                $this->command->error("  ✕ API error: " . $e->getMessage());
                return;
            }
        } while (count($batch) === $limit);

        $this->command->info("  ✓ Fetched " . count($allProducts) . " base products from DummyJSON");

        // Get approved sellers and their user_ids
        $sellers = Seller::where('status', 'approved')->with('user')->get();
        if ($sellers->isEmpty()) {
            $this->command->error('  ✕ No approved sellers found. Run DemoUserSeeder first.');
            return;
        }

        $categories = Category::all()->keyBy('slug');

        $this->command->info("Creating products with variants (target ~{$this->targetTotal})…");

        $bar = $this->command->getOutput()->createProgressBar($this->targetTotal);
        $bar->start();

        $created = 0;
        $skipped = 0;
        $sellerIdx = 0;
        $sellerCount = $sellers->count();

        // Shuffle base products so categories get mixed across sellers naturally.
        shuffle($allProducts);

        foreach ($allProducts as $baseIdx => $baseProduct) {
            if ($created >= $this->targetTotal) break;

            // Resolve category
            $dummyCat = $baseProduct['category'] ?? 'home-decoration';
            $localSlug = $this->categoryMap[$dummyCat] ?? 'home-decoration';
            $category = $categories->get($localSlug);

            if (!$category) {
                $skipped++;
                continue;
            }

            // Decide how many sellers list this product. ~25% are multi-seller
            // (like real branded items), ~75% are unique to one seller.
            $sellersForThisProduct = (mt_rand() / mt_getrandmax()) < $this->multiSellerRatio
                ? mt_rand(2, min(3, $sellerCount))
                : 1;

            // Pick a unique set of sellers for this product (no duplicates).
            $chosenSellers = $sellers->shuffle()->take($sellersForThisProduct);

            /* Pool of images available for THIS base product.
               When multiple sellers list it, each seller gets a different
               image so the listing doesn't show duplicate thumbnails.
               (Real marketplaces — different sellers photograph the same
               product from different angles / studios.) */
            $imagePool = [];
            if (!empty($baseProduct['thumbnail'])) $imagePool[] = $baseProduct['thumbnail'];
            if (!empty($baseProduct['images']) && is_array($baseProduct['images'])) {
                foreach ($baseProduct['images'] as $img) {
                    if (!in_array($img, $imagePool)) $imagePool[] = $img;
                }
            }
            $imageIndex = 0;

            foreach ($chosenSellers as $seller) {
                if ($created >= $this->targetTotal) break 2;

                // SAME product name across sellers — realistic for branded items.
                $variantName = $baseProduct['title'];

                // SKU must be unique → include seller id (each seller has own SKU).
                $sku = strtoupper(Str::slug($baseProduct['title'])) . '-S' . $seller->id;

                // Small per-seller price variation so listings look natural
                // (different sellers price the same product slightly differently).
                $basePrice = (float) ($baseProduct['price'] ?? 50);
                $priceJitter = 0.92 + (mt_rand(0, 16) / 100); // 0.92–1.08
                $price = round($basePrice * $priceJitter, 2);

                $discountPct = (float) ($baseProduct['discountPercentage'] ?? 0);
                $onSale = $discountPct > 0;
                $salePrice = $onSale ? round($price * (1 - $discountPct / 100), 2) : null;
                $comparePrice = $onSale ? round($price * 1.20, 2) : null;

                /* Pick this seller's main image from the pool by rotating.
                   First seller gets imagePool[0], second seller gets [1], etc.
                   When pool is small, we wrap around but still try to vary. */
                if (count($imagePool) > 0) {
                    $thumbnail = $imagePool[$imageIndex % count($imagePool)];
                    /* Gallery: same pool but rotated so the main image appears first. */
                    $gallery = array_values(array_unique(array_merge(
                        array_slice($imagePool, $imageIndex % count($imagePool)),
                        array_slice($imagePool, 0, $imageIndex % count($imagePool))
                    )));
                } else {
                    $thumbnail = null;
                    $gallery = [];
                }
                $imageIndex++;

                Product::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'name'             => Str::limit($variantName, 250, ''),
                        'slug'             => Str::slug($variantName) . '-' . Str::lower(Str::random(5)),
                        'user_id'          => $seller->user_id,
                        'seller_id'        => $seller->id,
                        'description'      => $baseProduct['description'] ?? 'High-quality product. ' . $variantName,
                        'short_description' => Str::limit($baseProduct['description'] ?? '', 150),
                        'price'            => $price,
                        'compare_price'    => $comparePrice,
                        'sale_price'       => $salePrice,
                        'on_sale'          => $onSale,
                        'stock_quantity'   => $baseProduct['stock'] ?? rand(10, 100),
                        'image'            => $thumbnail,
                        'gallery'          => $gallery,
                        'specifications'   => [
                            'Brand'    => $baseProduct['brand'] ?? 'Generic',
                            'Category' => $category->name,
                            'SKU'      => $sku,
                            'Warranty' => '12 months',
                        ],
                        'is_active'        => true,
                        'is_featured'      => rand(1, 5) === 1,  // ~20% featured
                        'category_id'      => $category->id,
                        'page_views'       => rand(50, 5000),
                        /* Spread created_at over the last 90 days so the
                           "Latest" sort doesn't cluster all seeded products. */
                        'created_at'       => now()->subDays(rand(0, 90))->subMinutes(rand(0, 1440)),
                        'updated_at'       => now(),
                    ]
                );

                $created++;
                $bar->advance();
            }

            if ($created >= $this->targetTotal) break;
        }

        $bar->finish();
        $this->command->newLine();

        $this->command->info("  ✓ Created {$created} products");
        if ($skipped > 0) {
            $this->command->warn("  ⚠ Skipped {$skipped} base products (category mapping issue)");
        }

        // Distribution summary
        $this->command->info('  Distribution per seller:');
        foreach ($sellers as $seller) {
            $count = Product::where('seller_id', $seller->id)->count();
            $this->command->info("    - {$seller->store_name}: {$count} products");
        }
    }
}
