<?php

namespace App\Docs\Auth;

class AuthTokenController
{
    /**
     *
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Login"},
     *     summary="Login",
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
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="test@test.ru"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="device_name",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Macintosh 128K"
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
     *                @OA\Property(property="data", type="object",
     *                              @OA\Property(property="user", type="object",
     *                                  @OA\Property(property="id", type="integer", example="9976801b-6070-4357-bab2-fb47219dad57"),
     *                                  @OA\Property(property="email", type="string", example="test@test.ru"),
     *                                  @OA\Property(property="profile", type="object", example="{}"),
     *                              ),
     *                              @OA\Property(property="token", type="string", example="token"),
     *                ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * )
     *
     *
     */
    public function store() {}

    /**
     *
     * @OA\Delete(
     *     path="/logout",
     *     operationId="logout",
     *     tags={"Login"},
     *     summary="Logout",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="[]"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     *)
     */
    public function destroy() {}
}