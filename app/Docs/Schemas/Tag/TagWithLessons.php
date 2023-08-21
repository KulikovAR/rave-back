<?php

namespace App\Docs\Schemas\Tag;

/**
 * @OA\Schema(
 *     title="TagWithLessons",
 *     description="TagWithLessons model",
 *     @OA\Xml(
 *         name="TagWithLessons"
 *     )
 * )
 */

class TagWithLessons
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
     *     example="https://trueschool/TagWithLessonss/TagWithLessons1.png"
     * )
     *
     * @var string
     */
    private $image;

    /**
     * @OA\Property(
     *     title="lessons",
     *     description="Уроки",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Lesson"
     *          ),
     *          @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 ref="#/components/schemas/Meta"
     *          ),
     *          @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 ref="#/components/schemas/Links"
     *          )
     *      )
     *     )
     * )
     *
     * @var string
     */

    private $lessons;
}