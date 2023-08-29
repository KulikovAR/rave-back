<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class AnnounceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => $this->faker->realText(100),
            'description'  => $this->faker->realText(),
            'video_path'   => url('videos/video1.webm'),
            'preview_path' => url('previews/test_preview.png'),
            'release_at' => $this->faker->date()
        ];
    }
}