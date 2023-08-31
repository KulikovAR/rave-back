<?php

namespace App\Docs;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Documentation API",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Tag(
 *      name="Registration",
 *      description="Регистрация"
 * )
 * @OA\Tag(
 *      name="Login",
 *      description="Авторизация"
 * )
 * @OA\Tag(
 *      name="Lesson",
 *      description="Видеоуроки"
 * )
 * @OA\Tag(
 *      name="Comment",
 *      description="Комментарии"
 * )
 * @OA\Tag(
 *      name="Announce",
 *      description="Анонс"
 * )
 * @OA\Tag(
 *      name="Tag",
 *      description="Тэги"
 * )
 * @OA\Tag(
 *      name="Shorts",
 *      description="Короткие видео"
 * )
 * @OA\Tag(
 *      name="Quiz",
 *      description="Тесты"
 * )
 * @OA\Tag(
 *      name="QuizResult",
 *      description="Результаты тестов"
 * )
 * @OA\Tag(
 *      name="Tag",
 *      description="Теги"
 * )
 * @OA\Tag(
 *      name="UserProfile",
 *      description="Настройки пользователя"
 * )
 * @OA\Tag(
 *      name="Orders",
 *      description="Заказы и оплата"
 * )
 * @OA\Tag(
 *      name="Assets",
 *      description="Данные для UI"
 * )
 * @OA\Tag(
 *      name="Device",
 *      description="Девайсы"
 * )
 * @OA\Tag(
 *      name="CSRF",
 *      description="session auth with CSRF protection"
 * )
 * @OA\Server(
 *      url="/api/v1",
 *      description="API Server"
 * )
 *
 * @OA\Server(
 *      url="/",
 *      description="Session Server"
 * )
 * 
 * @OA\Examples(
 *        summary = "Создать результаты квиза",
 *        example = "QuizResults",
 *        value = {
 *           "quiz_id": "99f649a7-5b10-4b2f-9dc9-2c226ad7dd70",
 *           "data": {
 *               {
 *                   "answers": {
 *                       "Вот меньшой, Алкид, тот не так ловко скроен, как у бессмертного кощея, где-то за горами и закрыта такою толстою скорлупою, что все, что ни попадалось. День, кажется, был заключен порцией холодной.",
 *                       "Ну скажи только, к кому едешь? — А может, в хозяйстве-то как-нибудь под случай понадобятся… — — Еще я хотел вас попросить, чтобы эта сделка осталась между нами, по — ревизии как живые, — сказал.",
 *                       "Признаюсь, этого — никак нельзя говорить, как на кого смотреть, всякую минуту будет бояться, чтобы не входить в дальнейшие разговоры по этой части, по полтора — рубли, извольте, дам, а больше не."
 *                   },
 *                   "question": "Однако ж это обидно! что же твой приятель не едет?» — «Погоди, душенька, приедет». А вот — попробуй он играть дублетом, так вот — не умею играть, разве что-нибудь мне дашь вперед. «Сем-ка я."
 *               }
 *           }
 *       }
 *   )
 * @OA\RequestBody(
 *     request="QuizResults",
 *     description="Результаты квиза",
 *     required=true,
 *     @OA\JsonContent(
 *       examples = {
 *          "example_1" : @OA\Schema( ref="#/components/examples/QuizResults", example="#/components/examples/QuizResults")
 *      }
 *    )
 * )
 * 
 */

class ApiDocs
{

}
