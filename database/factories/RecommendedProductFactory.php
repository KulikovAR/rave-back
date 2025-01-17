<?php

namespace Database\Factories;

use App\Models\RecommendedProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecommendedProductFactory extends Factory
{
    protected $model = RecommendedProduct::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'recommended_product_id' => \App\Models\Product::factory(),
        ];
    }
}