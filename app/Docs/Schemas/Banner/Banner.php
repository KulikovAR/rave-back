<?php

namespace App\Docs\Schemas\Banner;

/**
 * @OA\Schema(
 *     title="Banner",
 *     description="Banner model",
 *     @OA\Xml(
 *         name="Banner"
 *     )
 * )
 */

class Banner
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id баннера",
     *     format="string",
     *     example="135"
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     title="title",
     *     description="Название баннера",
     *     format="string",
     *     example="Баннер для главной страницы"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="action_url",
     *     description="url для привязки к баннеру",
     *     format="string",
     *     example="aspernatur-excepturi/nostrum"
     * )
     *
     * @var string
     */
    private $action_url;

    /**
     * @OA\Property(
     *     title="img",
     *     description="Относительный путь к баннеру",
     *     format="string",
     *     example="previews/test_preview.jpg"
     * )
     *
     * @var string
     */
    private $img;

    /**
     * @OA\Property(
     *     title="created_at",
     *     description="Дата создания",
     *     format="string",
     *     example="2023-09-07T19:27:07.000000Z"
     * )
     *
     * @var string
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="Дата обновления",
     *     format="string",
     *     example="2023-09-07T19:27:07.000000Z"
     * )
     *
     * @var string
     */
    private $updated_at;
}