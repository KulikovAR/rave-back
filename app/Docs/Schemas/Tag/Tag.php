<?php

namespace App\Docs\Schemas\Tag;

/**
 * @OA\Schema(
 *     title="Tag",
 *     description="Tag model",
 *     @OA\Xml(
 *         name="Tag"
 *     )
 * )
 */

class Tag
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id урока",
     *     format="string",
     *     example="99cf5f65-ad91-4b43-9cb7-88088e92ea68"
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     title="name",
     *     description="Название тега",
     *     format="string",
     *     example="Графический дизайн"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="name",
     *     description="Название тега",
     *     format="string",
     *     example="Графический дизайн"
     * )
     *
     * @var string
     */
    private $slug;

    /**
     * @OA\Property(
     *     title="image",
     *     description="Иконка",
     *     format="string",
     *     example="https://trueschool/tags/tag1.png"
     * )
     *
     * @var string
     */
    private $image;

}