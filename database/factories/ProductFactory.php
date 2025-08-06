<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->randomFloat(2, 10, 999);
        $salePrice = $this->faker->boolean(30) ? $this->faker->randomFloat(2, 5, $price - 1) : null;

        // Generate a base slug
        $baseSlug = Str::slug($name);

        // Append a unique suffix to the slug to guarantee uniqueness
        // Using faker's unique() method with a number or hash
        $slug = $baseSlug . '-' . $this->faker->unique()->randomNumber(5); // Appends a unique 5-digit number
        // Or you could use: $slug = $baseSlug . '-' . $this->faker->unique()->sha1(); // Appends a unique SHA1 hash

        return [
            'name' => ucwords($name),
            'slug' => $slug, // Use the guaranteed unique slug
            'description' => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->sentence(),
            'price' => $price,
            'sale_price' => $salePrice,
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-####-???')),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'image' => 'https://via.placeholder.com/400x400/059669/FFFFFF?text=' . urlencode(substr($name, 0, 10)),
            'gallery' => null,
            'is_featured' => $this->faker->boolean(20),
            'is_active' => true,
            // Important: In your DatabaseSeeder, you are explicitly setting category_id.
            // So, leaving it as null here in the factory definition is fine, or you can make it random.
            // The Seeder's explicit assignment will override this.
            'category_id' => Category::factory(), // If this is used, ensure Category::factory() actually creates a category.
                                                 // In your seeder, you manually assign 'category_id' so this might not be triggered.
        ];
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
