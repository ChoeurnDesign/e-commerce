<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electronics' => ['Smartphones', 'Laptops', 'Tablets', 'Headphones', 'Cameras'],
            'Clothing & Fashion' => ['Men\'s Clothing', 'Women\'s Clothing', 'Shoes', 'Accessories', 'Bags'],
            'Home & Garden' => ['Furniture', 'Kitchen', 'Bedding', 'Garden Tools', 'Decor'],
            'Sports & Outdoors' => ['Fitness Equipment', 'Sports Gear', 'Outdoor Recreation', 'Athletic Wear'],
            'Books & Media' => ['Fiction', 'Non-Fiction', 'Educational', 'Comics', 'Magazines'],
            'Health & Beauty' => ['Skincare', 'Makeup', 'Health Supplements', 'Personal Care'],
            'Toys & Games' => ['Action Figures', 'Board Games', 'Educational Toys', 'Video Games'],
            'Automotive' => ['Car Parts', 'Tools', 'Accessories', 'Maintenance']
        ];

        $parentCategories = array_keys($categories);
        $name = $this->faker->randomElement($parentCategories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'image' => 'https://via.placeholder.com/300x200/4F46E5/FFFFFF?text=' . urlencode($name),
            'parent_id' => null,
            'sort_order' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
        ];
    }

    /**
     * Create a child category
     */
    public function child($parentId = null)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            $subcategoryNames = [
                'Premium Collection',
                'Budget Friendly',
                'New Arrivals',
                'Best Sellers',
                'On Sale',
                'Limited Edition'
            ];

            $name = $this->faker->randomElement($subcategoryNames);

            return [
                'name' => $name,
                'slug' => Str::slug($name . '-' . $this->faker->numberBetween(1, 999)),
                'parent_id' => $parentId,
            ];
        });
    }
}
