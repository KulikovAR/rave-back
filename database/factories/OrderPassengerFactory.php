<?php

namespace Database\Factories;

use App\Enums\PassengerTypeEnum;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderPassengerFactory extends Factory
{


    public function definitionRequest(): array
    {
        $passengerParams = $this->definition();

        $passengerParams['document_expires'] = $this->faker->dateTimeInInterval('+30 years')->format('d.m.Y');
        $passengerParams['birthday']         = $this->faker->dateTimeInInterval('-30 years')->format('d.m.Y');

        return $passengerParams;
    }

    public function definition(): array
    {
        return [
            "firstname"        => strtoupper($this->faker->word),
            "lastname"         => strtoupper($this->faker->word),
            "country"          => 'US',
            "gender"           => $this->faker->randomElement([UserProfile::MALE, UserProfile::FEMALE]),
            "document_number"  => $this->faker->numerify('#########'),
            "document_expires" => $this->faker->dateTimeInInterval('+30 years')->format('Y-m-d'),
            "birthday"         => $this->faker->dateTimeInInterval('-30 years')->format('Y-m-d'),
        ];
    }
}
