<?php

namespace Tests\Feature;

use App\Models\Lesson;
use Tests\TestCase;

class LessonRatingTest extends TestCase
{
    const RATING = 4;
    const ADMIN_RATING = 5;
    /**
     * A basic feature test example.
     */
    public function test_store_rating(): void
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'post',
            route('lesson.rating.store'),
            [
                'lesson_id' => $lesson->id,
                'rating'    => self::RATING
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rating' => (float)self::RATING,
        ]);
    }

    public function test_lessons_have_user_rating() {
        $lesson   = $this->getTestLesson();

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
            'rating' => (float)self::RATING,
        ]);
    }

    public function test_lessons_have_admin_rating()
    {
        $lesson = $this->createTestLessonWithUser([
            'rating' => self::ADMIN_RATING
        ]);

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
            'rating' => (float) self::ADMIN_RATING,
        ]);
    }

    public function test_show_rating_by_lesson_id()
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'get',
            route('lesson.rating.show', [
                'lesson_id' => $lesson->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rating' => (float) self::RATING,
        ]);
    }


    public function test_delete_rating_by_lesson_id()
    {
        $lesson = $this->getTestLesson();

        $response = $this->json(
            'delete',
            route('lesson.rating.show', [
                'lesson_id' => $lesson->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
    }
}