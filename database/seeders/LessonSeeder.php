<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\CommentFactory;
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
        $user = User::where('email', UserSeeder::USER_EMAIL)->first();

        $lessons = Lesson::factory()
            ->hasAttached(
                Tag::all()->random(rand(1, 3)),
        )
            ->count(10)->create();

        foreach ($lessons as $lesson) {
            $lesson->lesson_additional_data()->create((new LessonAdditionalDataFactory())->definition());
            $lesson->quizzes()->create((new QuizFactory())->definition());
            $lesson->comments()->create((new CommentFactory())->definition());
        }

        User::where('email', UserSeeder::USER_EMAIL)
            ->first()
            ->lessons()
            ->sync($lessons);
    }
}