<?php

namespace Database\Factories;

use App\Models\ProductMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductMediaFactory extends Factory
{
    protected $model = ProductMedia::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'path' => $this->faker->imageUrl(640, 480, 'food', true, 'Product'),
        ];
    }
}