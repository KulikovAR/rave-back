<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PromocodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $promoCode = $this->faker->word;

        return [
            'title'      => $promoCode,
            'promo_code' => $promoCode,
            'commission' => 7,
            'discount'   => 3,
        ];
    }
}
