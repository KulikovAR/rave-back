<?php

namespace App\Docs;

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