<?php

namespace App\Docs;

class SearchFlightController
{
    /**
     * @OA\Get(
     *     path="/flights",
     *     operationId="search flights",
     *     tags={"Flights"},
     *     summary="search flights",
     *     @OA\Parameter(
     *          name="airport_from",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="SVO"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="airport_to",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="BCN"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date_start",
     *          in="query",
     *          required=true,
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *              example="30.10.2023"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date_back",
     *          in="query",
     *          description="dd.mm.YYYY",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="adults",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="children",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=0
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="babies",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=0
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="service_class",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"ECONOMY", "BUSINESS", "FIRST", "PREMIUM", "PREMIUM_BUSINESS", "PREMIUM_FIRST"}
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="time_begin",
     *          in="query",
     *          description = "minutes from 0 to 1439(=24hours)",
     *          @OA\Schema(
     *              type="number",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="time_end",
     *          in="query",
     *          description = "minutes from 0 to 1439(=24hours)",
     *          @OA\Schema(
     *              type="number",
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
     *      ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function index() {}
}