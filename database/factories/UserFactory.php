<?php

namespace Database\Factories;

use App\Models\TakeOut;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // 'phone'             => $this->faker->numerify('+7#########'),
            // 'phone_prefix'      => $this->faker->numerify('+##'),
            // 'phone_verified_at' => now(),
            'salt'              => Hash::make(Str::random(10)),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            //'language'          => config('app.locale'),
            'remember_token'    => Str::random(10),
            'is_partner'        => 1,
            'partner_takeout'   => TakeOut::TAKEOUT_CARD,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
