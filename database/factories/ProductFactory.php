<?php

namespace Database\Factories;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'ean' => fake()->unique()->numerify('#############'),
            'sukl_code' => null,
            'product_type' => ProductType::FOOD_SUPPLEMENT,
            'is_active' => true,
            'description' => fake()->sentence(),
            'composition' => fake()->sentence(),
            'dosage' => fake()->sentence(),
            'usage' => fake()->sentence(),
            'warnings' => fake()->sentence(),
        ];
    }
}
