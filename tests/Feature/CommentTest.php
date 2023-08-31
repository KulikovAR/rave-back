<?php

namespace Tests\Feature;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_not_auth(): void
    {
        $lesson = $this->getTestLesson();

        $response = $this->json('get', route(
            'comment.index',
            [
                'lesson_id' => $lesson->id
            ]
        )
        );

        $response->assertStatus(401);
    }

    public function test_view(): void
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'get',
            route(
                'comment.index',
                [
                    'lesson_id' => $lesson->id
                ],
            ),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

    
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'body',
                    'user' => [
                        'firstname',
                        'lastname'
                    ]
                ]
            ],
            'links', 
            'meta', 
        ]);

    }

    public function test_store_with_valid_data(): void
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'post',
            route('comment.store'),
            [
                'lesson_id' => $lesson->id,
                'body' => 'Test Comment'
            ],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
    }

    public function test_store_with_not_valid_data(): void
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'post',
            route('comment.store'),
            [
                'lesson_id' => $lesson->id,
                'body'      => 123
            ],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(422);
    }



    public function test_delete_comment(): void
    {
        $lesson = $this->getTestLesson();

        $comment = $lesson->comments()->first();

        $response = $this->json(
            'delete',
            route('comment.destroy',[
                'id' => $comment,
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
    }
}