<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $products = Product::inRandomOrder()->take(20)->get();
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found! Seed users first.');
            return;
        }

        $reviewCount = 0;

        foreach ($products as $product) {
            $numReviews = rand(0, 3);
            if (rand(0, 10) < 3) continue;

            for ($i = 0; $i < $numReviews; $i++) {
                $user = $users->random();

                if (Review::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->exists()
                ) {
                    continue;
                }

                $rating = rand(1, 5);
                $comment = match (true) {
                    $rating >= 4 => "I'm really impressed with the {$product->name}. Excellent quality and works perfectly. Would recommend!",
                    $rating == 3 => "The {$product->name} is decent but could be improved. Average product for the price.",
                    default => "Unfortunately {$product->name} didn't meet my expectations. Issues with quality.",
                };

                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'is_approved' => rand(0, 10) < 9,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                $reviewCount++;
            }
        }

        $this->command->info("Created {$reviewCount} product reviews");
    }
}
