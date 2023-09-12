<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use App\Enums\EnvironmentTypeEnum;
use Illuminate\Support\Facades\App;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        Banner::factory()->count(5)->create();
    }
}
