<?php

namespace App\Docs\Auth;

class AuthSessionController
{
    /**
     * *
     * @OA\Post(
     *     path="/login/session",
     *     operationId="login_session",
     *     tags={"CSRF"},
     *     summary="Login Session",
     *     description ="before request get csrf token",
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
     *              example="testtest"
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
     *                              @OA\Property(property="token", type="string", example="token"),
     *                              @OA\Property(property="user", type="object",
     *                                  @OA\Property(property="id", type="integer", example="9976801b-6070-4357-bab2-fb47219dad57"),
     *                                  @OA\Property(property="email", type="string", example="test@test.ru"),
     *                              ),
     *                ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Server(
     *      url="/",
     *      description="Session Server"
     *     ),
     * )
     *
     *
     */
    public function store()
    {
    }

    /**
     *
     * @OA\Delete(
     *     path="/logout/session",
     *     operationId="logout_session",
     *     tags={"CSRF"},
     *     summary="Logout",
     *     security={{"api": {}}},
     *     description ="before request get csrf token if there is no one",
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
     *     @OA\Server(
     *      url="/",
     *      description="Session Server"
     *     ),
     *)
     */
    public function destroy()
    {
    }
}