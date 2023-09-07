<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizResult>
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
        $quiz_result = [];

        for ($i = 0; $i < rand(1, 5); $i++) {
            $quiz_result[] = [
                'question' => $this->faker->realText(200),
                'answer'  => $this->faker->realText(200),
                'correct' => false,
            ];
        }

        return [
            'data' => json_encode($quiz_result),
            'curator_comment' => $this->faker->realText(200)
        ];
    }
}