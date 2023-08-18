<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Short;
use Database\Factories\SlideFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ShortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        $shorts = Short::factory()->count(20)->create();

        foreach($shorts as $short) {
            for ($i=0; $i < rand(2,5); $i++) { 
                $short->slides()->create((new SlideFactory())->definition());
            }
        }
    }
}