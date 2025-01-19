<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'restaurant_id' => \App\Models\Restaurant::factory(),
            'priority' => $this->faker->numberBetween(1, 10),
            'hidden' => $this->faker->boolean,
        ];
    }
}