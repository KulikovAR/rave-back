<?php

namespace Tests\Feature;

use App\Enums\QuizResultStatusEnum;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizResult;
use Database\Factories\QuizFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizResultsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_quiz_results_with_valid_data(): void
    {
        $quiz = $this->createTestQuiz();

        $response = $this->json(
            'post',
            route('quiz_results.store'),
            [
                'quiz_id'     => $quiz->id,
                "description" => "Дома он говорил про себя: «И ты, однако ж, остановил, впрочем, — они увидели, точно, границу, состоявшую из деревянного столбика и узенького рва. — Вот тебе на, будто не помнишь! — Нет, барин, не.",
                "data"        => [
                    [
                        "answer"   => "Вот меньшой, Алкид, тот не так ловко скроен, как у бессмертного кощея, где-то за горами и закрыта такою толстою скорлупою, что все, что ни попадалось. День, кажется, был заключен порцией холодной.",
                        "question" => "Однако ж это обидно! что же твой приятель не едет?» — «Погоди, душенька, приедет». А вот — попробуй он играть дублетом, так вот — не умею играть, разве что-нибудь мне дашь вперед. «Сем-ка я.",
                        "correct"  => null
                    ]
                ]
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);
    }


    public function test_store_quiz_results_with_not_valid_data(): void
    {
        $quiz = Quiz::firstOrFail();

        $response = $this->json(
            'post',
            route('quiz_results.store'),
            [
                'quiz_id'     => $quiz->id,
                "description" => "Дома он говорил про себя: «И ты, однако ж, остановил, впрочем, — они увидели, точно, границу, состоявшую из деревянного столбика и узенького рва. — Вот тебе на, будто не помнишь! — Нет, барин, не.",
                "data"        => [
                    [
                        "answers"  => ["Вот меньшой, Алкид, тот не так ловко скроен, как у бессмертного кощея, где-то за горами и закрыта такою толстою скорлупою, что все, что ни попадалось. День, кажется, был заключен порцией холодной."],
                        "question" => "Однако ж это обидно! что же твой приятель не едет?» — «Погоди, душенька, приедет». А вот — попробуй он играть дублетом, так вот — не умею играть, разве что-нибудь мне дашь вперед. «Сем-ка я.",
                    ]
                ]
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(422);
    }


    public function test_show_quiz_result(): void
    {
        $quiz = $this->getTestQuiz();

        $response = $this->json(
            'get',
            route('quiz_results.show', [
                'quiz_id' => $quiz->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);


        $response->assertJsonStructure([
            'data' => [
                'quiz',
                'data' => [
                    [
                        'question',
                        'answer',
                        'correct'
                    ]
                ],
                'curator_comment',
                'quiz_result_status'
            ],
            'message',
            'status'
        ]);
    }


    public function test_lesson_have_not_passed_status_of_quiz_result(): void
    {
        $lesson = $this->createTestLessonWithUser();

        $lesson->quizzes()->create((new QuizFactory())->definition());

        $response = $this->json(
            'get',
            route('lesson.index'),
            [
                'id' => $lesson->id
            ],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'quiz_result_status' => QuizResultStatusEnum::NOT_PASSED->value
        ]);
    }


    public function test_lesson_have_status_on_processing_of_quiz_result(): void
    {
        $lesson = $this->createTestLessonWithUser();

        $lesson->quizzes()->create((new QuizFactory())->definition());

        $user = $this->getTestUser();

        QuizResult::factory()->create([
            'verify'  => false,
            'user_id' => $user->id,
            'quiz_id' => $lesson->quiz->id
        ]);

        $response = $this->json(
            'get',
            route('lesson.index'),
            [
                'id' => $lesson->id
            ],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'quiz_result_status' => QuizResultStatusEnum::IS_PROCESSING->value
        ]);
    }


    public function test_lesson_have_status_vefiry_of_quiz_result(): void
    {
        $lesson = $this->createTestLessonWithUser();

        $lesson->quizzes()->create((new QuizFactory())->definition());

        $user = $this->getTestUser();

        $qr = QuizResult::factory()->create([
            'verify'  => true,
            'user_id' => $user->id,
            'quiz_id' => $lesson->quiz->id
        ]);

        $response = $this->json(
            'get',
            route('lesson.index'),
            [
                'id' => $lesson->id
            ],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
        
        $response->assertJsonFragment([
            'quiz_result_status' => QuizResultStatusEnum::VERIFIED->value
        ]);
    }
}