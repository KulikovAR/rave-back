<?php

namespace App\Docs;

class CommentController
{
    /**
     *
     * @OA\Get(
     *     path="/comment/{lesson_id}",
     *     tags={"Comment"},
     *     operationId="index_сomments",
     *     summary="Получить все комментарии урока",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="lesson_id",
     *          in="path",
     *          description="lesson id",
     *          @OA\Schema(
     *              type="string",
     *              example=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="pagination page",
     *          @OA\Schema(
     *              type="int64",
     *              example=1
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
     *                           ref="#/components/schemas/Comment",
     *                       )
     *                ),
     *                @OA\Property(property="links", type="object", ref="#/components/schemas/Links",),
     *                @OA\Property(property="meta", type="object",ref="#/components/schemas/Meta",),
     *             )
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
     * @OA\Post(
     *     path="/comment/",
     *     tags={"Comment"},
     *     operationId="store_сomments",
     *     summary="Создать комментарий урока",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="lesson_id",
     *          in="query",
     *          description="lesson id",
     *          @OA\Schema(
     *              type="string",
     *              example=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="body",
     *          in="query",
     *          description="comment body",
     *          @OA\Schema(
     *              type="string",
     *              example="Комментарий"
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
     *                @OA\Property(property="data", type="object", example={})
     *             )
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
    public function store()
    {

    }

    /**
     *
     * @OA\Delete(
     *     path="/comment/{id}",
     *     tags={"Comment"},
     *     operationId="delete_сomments",
     *     summary="Удалить все комментарии урока",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="comment id",
     *          @OA\Schema(
     *              type="string",
     *              example=""
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
     *                @OA\Property(property="data", type="object", example={})
     *             )
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
    public function destroy()
    {

    }
}