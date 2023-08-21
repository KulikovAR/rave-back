<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_not_auth(): void
    {
        $response = $this->json('get', route('tag.index'));

        $response->assertStatus(401);
    }

    public function test_index(): void
    {
        $response = $this->json(
            'get',
            route('tag.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status',
            'data' => [
                [
                    'name',
                    'slug',
                    'image'
                ]
            ]
        ]);
    }

    public function test_get_tag_with_lessons_by_tag_slug(): void
    {
        $tag = Tag::factory()->create();

        $lesson = Lesson::factory()->hasAttached($tag)->create();

        $lessonWithoutTag = Lesson::factory()->create();

        $user = User::factory()->hasAttached($lesson)->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $response = $this->json(
            'get',
            route('tag.show', ['slug' => $tag->slug]),
            headers: $this->getHeadersForUser($user)
        );


        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $lesson->id,
        ]);

        $response->assertJsonMissing([
            'id' => $lessonWithoutTag->id,
        ]);
    }
}