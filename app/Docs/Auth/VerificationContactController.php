<?php

namespace App\Docs\Auth;

class VerificationContactController
{
    /**
     *
     * @OA\Post(
     *     path="/verification/email",
     *     operationId="send_verification_email",
     *     tags={"Registration"},
     *     summary="Send verification email, update user email",
     *     description="Send verification email, update user email if not verified",
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
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     *)
     */
    public function sendEmailVerification() {}

    /**
     * @OA\Get(
     *     path="/verification/{id}/{hash}",
     *     operationId="verify_email",
     *     tags={"Registration"},
     *     summary="Verify email using url",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="hashed user id",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="hash",
     *          in="path",
     *          description="hash",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="expires",
     *          in="query",
     *          description="expires",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="signature",
     *          in="query",
     *          description="signature",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response="302",
     *          description="https://airsurfer.dev-2-tech.ru/",
     *     ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     *
     */
    public function verifyEmail() {}
}