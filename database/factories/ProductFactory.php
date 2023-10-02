<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name'=>$this->faker->name(),
            'body'=>$this->faker->name(),
            'price'=>$this->faker->numberBetween(1,20),
            'image'=>$this->faker->name(),
            'category_id'=>Category::factory()

        ];
    }
}
