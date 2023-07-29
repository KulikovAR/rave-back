<?php

namespace App\Docs;
/**
 * @OA\Schema(
 *   schema="Passenger",
 *   required={"passengers"},
 *   @OA\Property(
 *       property="passengers",
 *       type="array",
 *
 *       @OA\Items(
 *           @OA\Property(property="firstname", type="string", example="firstname"),
 *           @OA\Property(property="lastname", type="string", example="lastname"),
 *           @OA\Property(property="birthday", type="string", example="30.10.1925"),
 *           @OA\Property(property="country", type="string", example="RU"),
 *           @OA\Property(property="gender", type="string", example="male"),
 *           @OA\Property(property="type", type="string", example="adults"),
 *           @OA\Property(property="document_number", type="string", example="123755687"),
 *       ),
 *    )
 * )
 */
class OrdersController
{


    /**
     * @OA\Post(
     *     path="/orders",
     *     operationId="save_order for payment",
     *     tags={"Orders"},
     *     summary="save order for payment",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="test@test.ru"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone_prefix",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="+7"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="9253332211"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="comments",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="comments"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="order_type",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"normal","vip"}
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="order_start_booking",
     *          in="query",
     *          required=true,
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2025"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_city",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="hotel_city"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_check_in",
     *          in="query",
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2025"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_check_out",
     *          in="query",
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2030"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="promo_code",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="promo_code"
     *          )
     *     ),
     * @OA\Parameter(
     *          name="trip_to",
     *          in="query",
     *     required=true,
     *          description="pass one json object (ex: { to : {} } ) from /flights",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  type="object",
     *                  example="{}"
     *              )
     *          )
     *      ),
     * @OA\Parameter(
     *          name="trip_back",
     *          in="query",
     *          description="pass one json object (ex: { back: {} } ) from /flights",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  type="object",
     *                  example="{}"
     *              )
     *          )
     *     ),
     * @OA\RequestBody(
     *   request="passengers",
     *   required=true,
     *   description="property: type [enum] adults | children | babies <br><br> property: gender [enum] male | female ",
     *   @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/Passenger")
     *   )
     * ),
     * @OA\Response(
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
     * @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/orders",
     *     operationId="order_update",
     *     tags={"Orders"},
     *     summary="update order for payment",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="order_number",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="test@test.ru"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone_prefix",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="+7"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="9253332211"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="comments",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="comments"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="order_type",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"normal","vip"}
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="order_start_booking",
     *          in="query",
     *          required=true,
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2025"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_city",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="hotel_city"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_check_in",
     *          in="query",
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2025"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hotel_check_out",
     *          in="query",
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2030"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="promo_code",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="promo_code"
     *          )
     *     ),
     * @OA\Parameter(
     *          name="trip_to",
     *          in="query",
     *     required=true,
     *          description="pass one json object (ex: { to : {} } ) from /flights",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  type="object",
     *                  example="{}"
     *              )
     *          )
     *      ),
     * @OA\Parameter(
     *          name="trip_back",
     *          in="query",
     *          description="pass one json object (ex: { back: {} } ) from /flights",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  type="object",
     *                  example="{}"
     *              )
     *          )
     *     ),
     * @OA\RequestBody(
     *   request="passengers",
     *   required=true,
     *   description="property: type [enum] adults | children | babies <br><br> property: gender [enum] male | female ",
     *   @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/Passenger")
     *   )
     * ),
     * @OA\Response(
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
     * @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function update() {}

    /**
     * @OA\Get(
     *     path="/orders",
     *     operationId="orders_index_auth",
     *     tags={"Orders"},
     *     summary="get user orders",
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
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     *     @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     *
     */
    public function indexAuth() {}

    /**
     * @OA\Delete (
     *     path="/orders",
     *     operationId="order_destroy",
     *     tags={"Orders"},
     *     summary="destroy order",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description = "id of passenger",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     * @OA\Response(
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
     * @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function destroy() {}


}