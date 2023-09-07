<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
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
                'answers'   => [
                    $this->faker->realText(200),
                    $this->faker->realText(200),
                    $this->faker->realText(200),
                ],
            ];
        }

        return [
            'title'       => $this->faker->realText(20),
            'description' => $this->faker->realText(),
            'duration'    => rand(15, 30),
            'data'        => json_encode($quiz),
        ];
    }
}