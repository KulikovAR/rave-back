<?php

namespace App\Docs;

class AirportsController
{
    /**
     * @OA\Get(
     *     path="/airports",
     *     operationId="search airports",
     *     tags={"Flights"},
     *     summary="search airports",
     *     @OA\Parameter(
     *          name="airport",
     *          in="query",
     *          required=true,
     *          description="Страна, город, аеропорт",
     *          @OA\Schema(
     *              type="string",
     *              enum={"Россия","Москва","Шереметьево","SVO","Ithtvtnmtdj"}
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
    public function index() {}
}