<?php

namespace App\Docs\Auth;


class Csrf
{
    /**
     * @OA\Get(
     *     path="/sanctum/csrf-cookie",
     *     operationId="csrf",
     *     tags={"CSRF"},
     *     summary="Get csrf token. Use Session server prefix.",
     *     @OA\Response(
     *          response="200",
     *          description="Sets csrf cookie, must be attached to every request",
     *     ),
     *     @OA\Server(
     *      url="/",
     *      description="Session Server"
     *     ),
     * )
     *
     */
    public function redirectToProvider()
    {
    }
}