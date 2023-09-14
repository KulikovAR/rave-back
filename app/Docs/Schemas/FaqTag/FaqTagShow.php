<?php

namespace App\Docs\Schemas\FaqTag;

/**
 * @OA\Schema(
 *     title="FaqTagShow",
 *     description="FaqTagShow model",
 *     @OA\Xml(
 *         name="FaqTagShow"
 *     )
 * )
 */

class FaqTagShow
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
     *     description="Название тега",
     *     format="string",
     *     example="Видео-уроки"
     * )
     *
     * @var string
     */
    private $name;


    /**
     * @OA\Property(
     *     title="faqs",
     *     description="Faqs",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Faq"
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

    private $faqs;
}