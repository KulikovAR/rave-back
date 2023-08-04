<?php

namespace Tests\Feature;

use App\Http\Resources\Lesson\LessonResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Lesson;
use Tests\TestCase;

class LessonTest extends TestCase
{
    public function test_not_auth(): void
    {
        $response = $this->json('get', route('lesson.index'));

        $response->assertStatus(401);
    }

    public function test_auth(): void
    {
        $response = $this->json('get', route('lesson.index'), headers: $this->getHeadersForUser());

        $response->assertStatus(200);
    }

    public function test_resource_view(): void
    {

        $lesson = Lesson::factory()->create();

        $response = $this->json('get', route('lesson.index'), ['id' => $lesson->id] ,$this->getHeadersForUser());

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status',
            'data'
        ]);

        $this->assertSameResource(new LessonResource($lesson), $response->json('data'));
    }
}
