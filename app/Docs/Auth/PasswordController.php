<?php

namespace App\Docs\Auth;

class PasswordController
{
    /**
     * @OA\Post(
     *     path="/password/send",
     *     operationId="send_password",
     *     tags={"Login"},
     *     summary="Send password url",
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example="Email Sent"),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * )
     */
    public function sendPasswordLink() {}

    /**
     * @OA\Post(
     *     path="/password/reset",
     *     tags={"Login"},
     *     operationId="reset_password",
     *     summary="Reset password",
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="token",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example="Email Sent"),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     * )
     */
    public function store() {}

    /**
     * @OA\Patch(
     *     path="/password",
     *     tags={"UserProfile"},
     *     operationId="update_password",
     *     summary="Upade password",
     *     security={{"api": {}}},
     *
     *     @OA\Parameter(
     *          name="current_password",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          in="query",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example="Email Sent"),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     */
    public function update() {}
}
