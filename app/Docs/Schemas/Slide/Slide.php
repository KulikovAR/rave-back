<?php

namespace App\Docs\Schemas\Slide;

/**
 * @OA\Schema(
 *     title="Slide",
 *     description="Slide model",
 *     @OA\Xml(
 *         name="Slide"
 *     )
 * )
 */

class Slide
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
     *     title="file",
     *     description="Путь к файлу",
     *     format="string",
     *     example="/slides/slide1.mp4"
     * )
     *
     * @var string
     */
    private $file;
}