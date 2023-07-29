<?php

namespace Database\Factories;

use App\Enums\PassengerTypeEnum;
use App\Models\Order;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Feature\TripsFetcherServiceTest;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson   = json_encode($flightsArr[0]['to']);
        $flightBackJson = json_encode($flightsArr[0]['back']);

        return [
            "email"        => UserSeeder::USER_EMAIL,
            "phone_prefix" => '+7',
            "phone"        => $this->faker->numerify('#########'),
            'comment'      => $this->faker->sentence,

            "price"      => $this->faker->numerify('####'),
            "promo_code" => $this->faker->numerify('######'),

            "order_type"          => $this->faker->randomElement([Order::TYPE_NORMAL, Order::TYPE_VIP]),
            "order_start_booking" => $this->faker->dateTimeInInterval('+30 days')->format('Y-m-d'),
            'order_status'        => Order::CREATED,
            'order_number'        => substr(time(), -5),

            'trip_to'   => $flightToJson,
            'trip_back' => $flightBackJson,

            "hotel_city"      => $this->faker->city,
            "hotel_check_in"  => $this->faker->dateTimeInInterval('+30 days')->format('Y-m-d'),
            "hotel_check_out" => $this->faker->dateTimeInInterval('+60 days')->format('Y-m-d'),
        ];
    }
}
