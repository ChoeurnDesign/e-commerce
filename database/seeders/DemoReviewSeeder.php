<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoReviewSeeder extends Seeder
{
    /** Realistic review templates by rating */
    protected array $reviews = [
        5 => [
            'Absolutely love this! Exceeded my expectations in every way.',
            'Perfect quality, fast shipping. Will definitely buy again!',
            'Best purchase I made this year. Highly recommended.',
            'Exactly as described. 5 stars all the way.',
            'Amazing product and excellent customer service.',
            'Quality is top-notch. Worth every penny.',
        ],
        4 => [
            'Good product overall, minor issues with packaging but item is great.',
            'Works as advertised. Slightly slow shipping but worth it.',
            'Very happy with my purchase. Would buy again.',
            'Great value for the price. Recommended.',
            'Solid build quality. A few small flaws but nothing major.',
        ],
        3 => [
            'It is okay. Not amazing but does the job.',
            'Average product. You get what you pay for.',
            'Decent quality but I expected more for the price.',
            'Works fine but had some issues at first.',
        ],
        2 => [
            'Disappointed with the quality. Not as described.',
            'Had to contact support twice. Eventually resolved.',
            'Below my expectations. Probably won\'t reorder.',
        ],
        1 => [
            'Item arrived damaged. Requesting refund.',
            'Very poor quality. Not happy at all.',
        ],
    ];

    public function run(): void
    {
        $this->command->info('Creating demo reviews...');

        $products  = Product::inRandomOrder()->limit(40)->get();
        $customers = User::where('role', 'user')->get();

        if ($products->isEmpty() || $customers->isEmpty()) return;

        $count = 0;

        foreach ($products as $product) {
            // Cap by total customers so we never try to assign duplicates.
            $reviewCount = min(rand(1, 4), $customers->count());

            // Pick UNIQUE customers per product — prevents the
            // (user_id, product_id) unique-constraint collision.
            $reviewers = $customers->shuffle()->take($reviewCount);

            foreach ($reviewers as $customer) {
                $rating = $this->weightedRating();
                $comment = collect($this->reviews[$rating])->random();

                Review::firstOrCreate(
                    [
                        'user_id'    => $customer->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'rating'      => $rating,
                        'comment'     => $comment,
                        'is_approved' => true,
                        'created_at'  => now()->subDays(rand(1, 90)),
                    ]
                );
                $count++;
            }
        }

        $this->command->info("  ✓ Created {$count} reviews across {$products->count()} products");
    }

    protected function weightedRating(): int
    {
        $r = rand(1, 100);
        return match (true) {
            $r <= 50 => 5,
            $r <= 80 => 4,
            $r <= 93 => 3,
            $r <= 98 => 2,
            default  => 1,
        };
    }
}
