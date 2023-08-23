<?php

namespace Tests\Feature;

use App\Models\Lesson;
use Tests\TestCase;

class LessonRatingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_rating(): void
    {
        $lesson = Lesson::factory()->create();
        $rating = 5;

        $this->getTestUser()->lessons()->sync($lesson);

        $response = $this->json(
            'post',
            route('lesson.rating.store'),
            [
                'lesson_id' => $lesson->id,
                'rating'    => $rating
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response = $this->json(
            'get',
            route('lesson.index'),
            [
                'id' => $lesson->id
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rating' => $rating,
        ]);
    }


    public function test_admin_rating(): void
    {
        $admin_rating = 5;
        $rating = 4;

        $lesson = Lesson::factory()->create([
            'rating' => $admin_rating
        ]);

        $this->getTestUser()->lessons()->sync($lesson);

        $response = $this->json(
            'post',
            route('lesson.rating.store'),
            [
                'lesson_id' => $lesson->id,
                'rating'    => $rating
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response = $this->json(
            'get',
            route('lesson.index'),
            [
                'id' => $lesson->id
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rating' => $admin_rating,
        ]);
    }

}