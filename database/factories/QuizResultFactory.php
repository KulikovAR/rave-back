<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class QuizResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quiz = [];

        for ($i = 0; $i < rand(1, 5); $i++) {
            $quiz[] = [
                'question' => $this->faker->realText(200),
                'answers'  => [
                    $this->faker->realText(200),
                    $this->faker->realText(200),
                    $this->faker->realText(200),
                ],
            ];
        }

        return [
            'data' => json_encode($quiz),
        ];
    }
}