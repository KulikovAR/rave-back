<?php

namespace App\Docs;

class FaqTagController
{
    /**
     *
     * @OA\Get(
     *     path="/faq_tag",
     *     tags={"FaqTag"},
     *     operationId="index_faq_tag",
     *     summary="Получить все faq теги",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", type="object", ref="#/components/schemas/FaqTag")
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
     *     path="/faq_tag/{id}",
     *     tags={"FaqTag"},
     *     operationId="show_faq_tag",
     *     summary="Получить faq тэг по id с faqs",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="faq_page",
     *          in="query",
     *          description="pagination page for faqs",
     *          @OA\Schema(
     *              type="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="faq tag id",
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
     *                @OA\Property(property="data", type="object", ref="#/components/schemas/FaqTagShow")
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