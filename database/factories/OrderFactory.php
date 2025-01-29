<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_phone' => $this->faker->phoneNumber,
            'total_price' => $this->faker->numberBetween(1000, 50000),
            'status' => $this->faker->randomElement(['new', 'processing', 'completed', 'canceled']),
            'type' => $this->faker->randomElement(['Самовывоз', 'Доставка']),
            'customer_name' => $this->faker->name,
        ];
    }
}
