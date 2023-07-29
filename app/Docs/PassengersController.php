<?php

namespace App\Docs;

class PassengersController
{


    /**
     * @OA\Post(
     *     path="/passengers",
     *     operationId="passenger_create",
     *     tags={"UserProfile"},
     *     summary="Save user passenger",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="country",
     *          in="query",
     *          required=true,
     *          description = "Input country code: RU / US / GB",
     *          @OA\Schema(
     *              type="string",
     *              example="RU"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="firstname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="firstname"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="lastname"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="birthday",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.1922"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="gender",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"male","female"}
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_number",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="34343aaa4343"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_expires",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.2087"
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
    public function store() {}

    /**
     *
     * @OA\Get(
     *     path="/passengers",
     *     tags={"UserProfile"},
     *     operationId="index_passengers",
     *     summary="View user passsengers",
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
     *
     */
    public function index() {}

    /**
     * @OA\Put(
     *     path="/passengers",
     *     operationId="passenger_update",
     *     tags={"UserProfile"},
     *     summary="Update user passenger",
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
     *     @OA\Parameter(
     *          name="country",
     *          in="query",
     *          required=true,
     *          description = "Input country code: RU / US / GB",
     *          @OA\Schema(
     *              type="string",
     *              example="RU"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="firstname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="firstname"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="lastname"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="birthday",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.1922"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="gender",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"male","female"}
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_number",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="34343aaa4343"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_expires",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.2087"
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
    public function update() {}

    /**
     * @OA\Delete (
     *     path="/passengers",
     *     operationId="passenger_destroy",
     *     tags={"UserProfile"},
     *     summary="Destroy user passenger",
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