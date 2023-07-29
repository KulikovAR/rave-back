<?php

namespace App\Docs;

class TakeOutController
{
    /**
     * @OA\Get(
     *     path="/partners/takeouts",
     *     operationId="get_takeouts",
     *     tags={"Partners"},
     *     summary="get takeouts",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=true,
     *          description="page",
     *          @OA\Schema(
     *              type="number",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object", example="[]"),
     *                @OA\Property(property="links", type="object", example="{}"),
     *                @OA\Property(property="meta", type="object", example="{}"),
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
    public function index() {}


    /**
     * @OA\Post(
     *     path="/partners/takeouts",
     *     operationId="send_takeouts_msg",
     *     tags={"Partners"},
     *     summary="send takeouts request",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="amount",
     *          in="query",
     *          required=true,
     *          description="Сумма",
     *          @OA\Schema(
     *              type="number",
     *              example=1000
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="takeoutable_type",
     *          in="query",
     *          required=true,
     *          description="Вывод по реквизитам/карте",
     *          @OA\Schema(
     *              type="string",
     *              enum={"credit-card","bank"}
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="takeoutable_id",
     *          in="query",
     *          required=true,
     *          description="Id реквизитам/карте",
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
}