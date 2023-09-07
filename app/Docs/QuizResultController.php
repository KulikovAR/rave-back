<?php

namespace App\Docs;

/**
 * @OA\Schema(
 *   schema="QuizResult",
 *   required={"data"},
 *      @OA\Property(
 *       property="data",
 *       type="array",
 *       @OA\Items(
 *           @OA\Property(property="answer", type="string", example="Однако ж это обидно! что же твой приятель не едет?» "),
 *           @OA\Property(property="question", type="string", example="Однако ж это обидно! что же твой приятель не едет?» "),
 *       ),
 *       @OA\Property(
 *          property="quiz_id",
 *          type="string",
 *          example="99f649a7-5b10-4b2f-9dc9-2c226ad7dd70"
 *      )
 *   )
 * )
 */

class QuizResultController
{
    /**
     *
     * @OA\Post(
     *     path="/quiz_results",
     *     tags={"QuizResult"},
     *     operationId="store_quiz_results",
     *     summary="Сформировать ответ для квиза",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="quiz_id",
     *          in="query",
     *          description="quiz model id",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *      request="QuizResult",
     *      required=true,
     *      description="QuizResult",
     *      @OA\MediaType(
     *      mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/QuizResult")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/requestBodies/QuizResults")
     *       ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     *      @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *      @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     */
    public function store()
    {

    }

    /**
     *
     * @OA\Get(
     *     path="/quiz_results/{quiz_id}",
     *     tags={"QuizResult"},
     *     operationId="show_quiz_results",
     *     summary="Получить результат квиза",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="quiz_id",
     *          in="path",
     *          description="quiz model id",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/requestBodies/QuizResults")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/requestBodies/QuizResults")
     *       ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     *      @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *      @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     */
    public function show()
    {

    }
}