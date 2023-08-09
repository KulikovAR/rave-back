<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "phone_prefix"     => "+4",
            "phone"            => $this->faker->numerify('#########'),
            "country"          => 'US',
            "firstname"        => strtoupper($this->faker->word),
            "lastname"         => strtoupper($this->faker->word),
            "birthday"         => $this->faker->dateTimeInInterval('-30 years')->format('Y-m-d'),
            "gender"           => $this->faker->randomElement(['male', 'female']),
            "document_number"  => $this->faker->numerify('#########'),
            "document_expires" => $this->faker->dateTimeInInterval('+30 years')->format('Y-m-d'),
        ];
    }

    public function definitionRequest(): array
    {
        return [
            "phone_prefix"     => "+4",
            "phone"            => $this->faker->numerify('#########'),
            "country"          => 'RU',
            "firstname"        => strtoupper($this->faker->word),
            "lastname"         => strtoupper($this->faker->word),
            "birthday"         => $this->faker->dateTimeInInterval('-30 years')->format('d.m.Y'),
            "gender"           => $this->faker->randomElement(['male', 'female']),
            "document_number"  => $this->faker->numerify('#########'),
            "document_expires" => $this->faker->dateTimeInInterval('+30 years')->format('d.m.Y'),
        ];
    }
}