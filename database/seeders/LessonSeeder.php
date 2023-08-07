<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        Lesson::factory()->count(10)->create();
    }
}
