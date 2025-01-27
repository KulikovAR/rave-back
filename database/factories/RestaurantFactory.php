<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'photo' => $this->faker->imageUrl(640, 480, 'business', true, 'Restaurant'),
            'priority' => $this->faker->numberBetween(1, 10),
            'background_image' => $this->faker->imageUrl(640, 480),
            'map_image' => $this->faker->imageUrl(640, 480),
            'map_link' => $this->faker->url,
            'address' => $this->faker->address,
        ];
    }
}
