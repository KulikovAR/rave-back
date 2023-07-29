<?php

namespace App\Docs;

class CreditCardController
{
    /**
     * @OA\Get(
     *     path="/partners/credit_card",
     *     operationId="Get-credit_card",
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
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *     ),
     * )
     *
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/partners/credit_card",
     *     operationId="Post-credit_card",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="card_number",
     *          in="query",
     *          required=true,
     *          description="Номер карты",
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="card_bank_name",
     *          in="query",
     *          required=true,
     *          description="Название банка держателя карты",
     *          @OA\Schema(
     *              type="string",
     *              example="Tinkoff"
     *          )
     *     ),
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
     *     path="/partners/credit_card",
     *     operationId="Put-credit_card",
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
     *          name="card_number",
     *          in="query",
     *          required=true,
     *          description="Номер карты",
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="card_bank_name",
     *          in="query",
     *          required=true,
     *          description="Название банка держателя карты",
     *          @OA\Schema(
     *              type="string",
     *              example="Tinkoff"
     *          )
     *     ),
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
     *     path="/partners/credit_card",
     *     operationId="Delete-credit_card",
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