<?php

namespace App\Docs\Schemas\Short;

/**
 * @OA\Schema(
 *     title="Short",
 *     description="Short model",
 *     @OA\Xml(
 *         name="Short"
 *     )
 * )
 */

class Short
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
     *     title="title",
     *     description="Название",
     *     format="string",
     *     example="Новый урок"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="slide_count",
     *     description="Количество слайдов",
     *     format="int64",
     *     example=1
     * )
     *
     * @var string
     */
    private $slide_count;


    /**
     * @OA\Property(
     *     title="view_count",
     *     description="Количество просмотров",
     *     format="int64",
     *     example=1
     * )
     *
     * @var string
     */
    private $view_count;
}