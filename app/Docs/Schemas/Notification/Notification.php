<?php

namespace App\Docs\Schemas\Notification;

/**
 * @OA\Schema(
 *     title="Notification",
 *     description="Notification model",
 *     @OA\Xml(
 *         name="Notification"
 *     )
 * )
 */

class Notification
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id",
     *     format="string",
     *     example="99cf5f65-ad91-4b43-9cb7-88088e92ea68"
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     title="data",
     *     description="Data",
     *     format="object",
     *     example={}
     * )
     *
     * @var string
     */
    private $data;

}