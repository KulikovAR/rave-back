<?php

namespace App\Docs\Schemas\FaqTag;

/**
 * @OA\Schema(
 *     title="FaqTag",
 *     description="FaqTag model",
 *     @OA\Xml(
 *         name="FaqTag"
 *     )
 * )
 */

class FaqTag
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
     *     title="name",
     *     description="Название",
     *     format="string",
     *     example="Видео-уроки"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="FaqTag_tag",
     *     description="Тэг",
     *     format="object",
     *     example={}
     * )
     *
     * @var string
     */
    private $faqs;
}