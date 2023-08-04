<?php

namespace App\Docs;

class LessonController
{
    /**
     *
     * @OA\Get(
     *     path="/lessons",
     *     tags={"Lesson"},
     *     operationId="index_lessons",
     *     summary="Получить все уроки",
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     * )
     */
}
