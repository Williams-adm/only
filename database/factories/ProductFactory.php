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
        return [
            'sku' => $this->faker->unique()->numberBetween(100000, 999999),
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->text(150),
            /* 'price' => $this->faker->randomFloat(2, 20, 500), */
            'sub_category_id' => $this->faker->numberBetween(1, 18)
        ];
    }
}
