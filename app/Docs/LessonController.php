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
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="pagination page",
     *          @OA\Schema(
     *              type="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="model id",
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
     *                @OA\Property(property="data", type="array",
     *                      @OA\Items(
     *                           ref="#/components/schemas/Lesson",
     *                       )
     *                ),
     *                @OA\Property(property="links", type="object", ref="#/components/schemas/Links",),
     *                @OA\Property(property="meta", type="object",ref="#/components/schemas/Meta",),
     *             ),
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", type="object", ref="#/components/schemas/Lesson")
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
    public function index() {

    }

    /**
     *
     * @OA\Get(
     *     path="/lessons/{tag_slug}",
     *     tags={"Lesson"},
     *     operationId="get_by_tag_slug_lessons",
     *     summary="Получить все уроки",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="pagination page",
     *          @OA\Schema(
     *              type="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="tag_slug",
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
     *                @OA\Property(property="data", type="array",
     *                      @OA\Items(
     *                           ref="#/components/schemas/Lesson",
     *                       )
     *                ),
     *                @OA\Property(property="links", type="object", ref="#/components/schemas/Links",),
     *                @OA\Property(property="meta", type="object",ref="#/components/schemas/Meta",),
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
    public function getByTagSlug()
    {

    }
}
