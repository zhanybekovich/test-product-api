<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $old = $this->faker->randomFloat(2, 100, 1000);
        $price = $this->faker->randomFloat(2, 1, $old - 1);

        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'sku' => $this->faker->unique()->ean8(),
            'name' => $this->faker->sentence(),
            'prices' => [
                'old' => $old,
                'price' => $price,
            ],
            'description' => $this->faker->paragraph(),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
