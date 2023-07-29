<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'org_inn'     => $this->faker->numerify('############'),
            'org_kpp'     => $this->faker->numerify('#########'),
            'org_ogrn'    => $this->faker->numerify('#########'),
            'org_name'    => $this->faker->word,
            'org_address' => $this->faker->address,
            //'org_location' => $this->faker->address,

            'contact_fio'   => $this->faker->name,
            'contact_job'   => $this->faker->word,
            'contact_email' => $this->faker->email,
            'contact_tel'   => $this->faker->phoneNumber,

            'bank_bik'          => $this->faker->numerify('#########'),
            'bank_user_account' => $this->faker->numerify('#############'),
            'bank_account'      => $this->faker->numerify('#############'),
            'bank_name'         => $this->faker->name,
        ];
    }
}
