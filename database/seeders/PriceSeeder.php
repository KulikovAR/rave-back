<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        Price::create(
            config('site-values.prices_ru.prices') + ['locale' => 'ru']
        );
        Price::create(
            config('site-values.prices_us.prices') + ['locale' => 'en']
        );
    }
}