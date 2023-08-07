<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class LessonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }
        
        User::factory() ->hasAttached( Lesson::factory()->count(3))->count(5)->create();
    }
}
