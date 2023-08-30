<?php

namespace Tests\Feature;

use App\Http\Resources\Quiz\QuizResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_show_quiz_by_id(): void
    {

        $quiz = $this->getTestLesson()->quizzes()->first();


        $response = $this->json(
            'get',
            route('quiz.show', [
                'id' => $quiz->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $this->assertSameResource(new QuizResource($quiz), $response->json('data'));
    }
}