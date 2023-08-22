<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\LessonAdditionalDataFactory;
use Database\Factories\QuizFactory;
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

        $lessons = Lesson::factory()
            ->hasAttached(
                Tag::all()->random(rand(1,3)),
            )
            ->count(10)->create();

        foreach ($lessons as $lesson) {
            $lesson->lesson_additional_data()->create((new LessonAdditionalDataFactory())->definition());
            $lesson->quiz()->create((new QuizFactory())->definition());
        }
        
        User::where('email', UserSeeder::USER_EMAIL)
            ->first()
            ->lessons()
            ->sync($lessons);
    }
}