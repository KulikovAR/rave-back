<?php

namespace App\Docs;

class FaqController
{
    /**
     *
     * @OA\Get(
     *     path="/faq",
     *     tags={"Faq"},
     *     operationId="index_faqs",
     *     summary="Получить все faq",
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
     *                           ref="#/components/schemas/Faq",
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
    public function index()
    {

    }
}