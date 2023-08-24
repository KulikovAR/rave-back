<?php

namespace Tests\Feature;

use App\Models\Quiz;
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
                        "answers"  => [
                            "Вот меньшой, Алкид, тот не так ловко скроен, как у бессмертного кощея, где-то за горами и закрыта такою толстою скорлупою, что все, что ни попадалось. День, кажется, был заключен порцией холодной.",
                            "Ну скажи только, к кому едешь? — А может, в хозяйстве-то как-нибудь под случай понадобятся… — — Еще я хотел вас попросить, чтобы эта сделка осталась между нами, по — ревизии как живые, — сказал.",
                            "Признаюсь, этого — никак нельзя говорить, как на кого смотреть, всякую минуту будет бояться, чтобы не входить в дальнейшие разговоры по этой части, по полтора — рубли, извольте, дам, а больше не."
                        ],
                        "question" => "Однако ж это обидно! что же твой приятель не едет?» — «Погоди, душенька, приедет». А вот — попробуй он играть дублетом, так вот — не умею играть, разве что-нибудь мне дашь вперед. «Сем-ка я."
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
                        "answers"  => 'ответ!',
                        "question" => "Однако ж это обидно! что же твой приятель не едет?» — «Погоди, душенька, приедет». А вот — попробуй он играть дублетом, так вот — не умею играть, разве что-нибудь мне дашь вперед. «Сем-ка я."
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
                        'answers'
                    ]
                ]
            ],
            'message',
            'status'
        ]);
    }
}