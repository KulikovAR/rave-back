<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'            => $this->faker->realText(100),
            'description'      => $this->faker->realText(),
            'video_path'       => url('videos/video1.webm'),
            'preview_path'     => url('previews/test_preview.png'),
            'announc_date'     => $this->faker->date(),
            'duration'         => rand(5, 60),
            'order_in_display' => $this->faker->unique()->numberBetween(1, 10)
        ];
    }
}