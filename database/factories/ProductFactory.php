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
    public function definition()
    {
        return [
            //
            'name' => $this->faker->word(),
            'is_visible' => $this->faker->boolean(40),
            'info' => $this->faker->word(5),
            'quantity' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
