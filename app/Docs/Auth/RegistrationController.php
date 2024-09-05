<?php

namespace App\Docs\Auth;

class RegistrationController
{

    /**
     *
     * @OA\Post(
     *     path="/registration/email",
     *     operationId="email",
     *     tags={"Registration"},
     *     summary="Register account with email",
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="www@www.ru"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="www12345"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="www12345"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                              @OA\Property(property="user", type="object",
     *                                  @OA\Property(property="id", type="integer", example="9976801b-6070-4357-bab2-fb47219dad57"),
     *                                  @OA\Property(property="email", type="string", example="test@test.ru"),
     *                              ),
     *                  ),
     *                  @OA\Property(property="message", type="string", example="Please check your email."),
     *                  @OA\Property(property="status", type="string", example="OK"),
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
    public function emailRegistration() {}
}
