<?php

namespace App\Docs;

class NotificationController
{
    /**
     *
     * @OA\Get(
     *     path="/notification",
     *     tags={"Notification"},
     *     operationId="show_notification",
     *     summary="Получить уведомления юзера",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", type="array",
     *                      @OA\Items(
     *                           ref="#/components/schemas/Notification",
     *                       )
     *                ),
     *                @OA\Property(property="links", type="object", ref="#/components/schemas/Links",),
     *                @OA\Property(property="meta", type="object",ref="#/components/schemas/Meta",),
     *             ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     *      @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *      @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     */
    public function show()
    {

    }

    /**
     *
     * @OA\Post(
     *     path="/notification/{id}",
     *     tags={"Notification"},
     *     operationId="edit_notification",
     *     summary="Прочитать уведомление",
     *     security={{"api": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", type="object"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     *      @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *      @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     */
    public function store()
    {

    }
}