<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'image_path' => $this->faker->imageUrl(640, 480, 'advertising', true, 'Banner'),
            'priority' => $this->faker->numberBetween(1, 10),
        ];
    }
}