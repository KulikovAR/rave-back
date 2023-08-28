<?php

namespace App\Docs;

class DeviceController
{
    /**
     *
     * @OA\Get(
     *     path="/device/",
     *     tags={"Device"},
     *     operationId="index_devices",
     *     summary="Получить девайсы юзера",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     * )
     *
     *
     */
    public function index()
    {
    }


    /**
     *
     * @OA\Delete(
     *     path="/device",
     *     tags={"Device"},
     *     operationId="delete_devices",
     *     summary="Получить девайсы юзера",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Device name",
     *          @OA\Schema(
     *              type="string",
     *              example="Lenovo Thinkpad"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     * )
     *
     *
     */
    public function destroy()
    {
    }
}