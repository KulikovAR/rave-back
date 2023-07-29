<?php

namespace App\Docs;

class PromocodeController
{
    /**
     * @OA\Get(
     *     path="/partners/promocodes",
     *     operationId="Get-promocodes",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description = "pagination page number",
     *          @OA\Schema(
     *              type="number",
     *              example = 1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", type="object", example="[]"),
     *                @OA\Property(property="links", type="object", example="{}"),
     *                @OA\Property(property="meta", type="object", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/partners/promocodes",
     *     operationId="Post-promocodes",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="title"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="promo_code",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="promo_code"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="commission",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=7
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="discount",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=3
     *          )
     *     ),
     *
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/partners/promocodes",
     *     operationId="Put-promocodes",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description="model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="title"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="promo_code",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="promo_code"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="commission",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=7
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="discount",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=3
     *          )
     *     ),
     *
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/partners/promocodes",
     *     operationId="Delete-promocodes",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function destroy() {}
}