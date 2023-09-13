<?php

namespace App\Docs;

class PaymentsController
{
    /**
     *
     * @OA\Get(
     *     path="/payments/redirect",
     *     tags={"Orders"},
     *     operationId="redirect",
     *     summary="redirect to payments",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "user id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="order_type",
     *          in="query",
     *          description = "order type",
     *          @OA\Schema(
     *              type="string",
     *              enum={"normal","vip","premium"}
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
    public function redirect()
    {
    }

    /**
     *
     * @OA\Get(
     *     path="/payments/success",
     *     tags={"Orders"},
     *     operationId="success",
     *     summary="callback from success payments",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "order id",
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
    public function success()
    {
    }

    /**
     *
     * @OA\Get(
     *     path="/payments/failed",
     *     tags={"Orders"},
     *     operationId="failed",
     *     summary="callback from failed payments",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "order id",
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
    public function failed()
    {
    }

    /**
     *
     * @OA\Delete(
     *     path="/payments/unsubscribe",
     *     operationId="unsubscribe",
     *     tags={"Orders"},
     *     summary="unsubscribe",
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
    public function unsubscribe()
    {
    }
}
