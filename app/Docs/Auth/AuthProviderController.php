<?php

namespace App\Docs\Auth;

class AuthProviderController
{
    /**
     * @OA\Get(
     *     path="/auth/{provider}/redirect",
     *     operationId="redirectToSocialMedia",
     *     tags={"Login"},
     *     summary="Redirect to social media auth window",
     *
     *     @OA\Parameter(
     *          name="provider",
     *          in="path",
     *          description="For testing please visit :<br><br> <a href='/api/v1/auth/google/redirect' target='_blank'>/auth/google/redirect</a>",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="string",
     *              example="google"
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="302",
     *          description="https://airsurfer.dev-2-tech.ru/auth/redirect?token=[token]",
     *     ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     */
    public function redirectToProvider() {}
}
