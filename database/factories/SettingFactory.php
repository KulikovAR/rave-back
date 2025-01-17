<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'key' => $this->faker->unique()->word,
            'value' => $this->faker->text(50),
        ];
    }
}