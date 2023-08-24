<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_show_quiz_by_lesson_id(): void
    {

        $lesson = $this->getTestLesson();

        $response = $this->json(
            'get',
            route('quiz.show', [
                'lesson_id' => $lesson->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'title',
                    'description',
                    'data' => [
                        [
                            'question',
                            'answers'
                        ]
                    ]
                ]
            ],
            'message',
            'status'
        ]);
    }
}