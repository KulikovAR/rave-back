<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(100, 10000),
            'weight' => $this->faker->numberBetween(100, 2000),
            'calories' => $this->faker->numberBetween(50, 1000),
            'hidden' => $this->faker->boolean,
            'priority' => $this->faker->numberBetween(1, 10),
        ];
    }
}