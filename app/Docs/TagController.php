<?php

namespace App\Docs;

class TagController
{
    /**
     *
     * @OA\Get(
     *     path="/tags",
     *     tags={"Tag"},
     *     operationId="index_tags",
     *     summary="Получить все теги",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", type="object", ref="#/components/schemas/Tag")
     *             ),
     *         )
     *     ),
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
    public function index()
    {

    }

    /**
     *
     * @OA\Get(
     *     path="/tags/{slug}",
     *     tags={"Tag"},
     *     operationId="show_tag",
     *     summary="Получить тэг по слагу с видоуроками",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="lesson_page",
     *          in="query",
     *          description="pagination page for lessons",
     *          @OA\Schema(
     *              type="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="slug",
     *          in="path",
     *          description="tag slug",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", type="object", ref="#/components/schemas/TagWithLessons")
     *             ),
     *         )
     *     ),
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