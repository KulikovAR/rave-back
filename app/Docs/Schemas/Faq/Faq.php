<?php

namespace App\Docs\Schemas\Faq;

/**
 * @OA\Schema(
 *     title="Faq",
 *     description="faq model",
 *     @OA\Xml(
 *         name="Faq"
 *     )
 * )
 */

class Faq
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
     *     title="question",
     *     description="Вопрос",
     *     format="string",
     *     example="Как работает TrueSchool?"
     * )
     *
     * @var string
     */
    private $question;


    /**
     * @OA\Property(
     *     title="answer",
     *     description="Ответ",
     *     format="string",
     *     example="Вы можете поменять месячную подписку на годовой тариф «Премиум» или перейти на тариф «Ультима». Отмените текущую подписку и после завершения ее срока действия подпишитесь на другой тариф. Тариф «Ультима» бессрочный, поэтому изменить его нельзя."
     * )
     *
     * @var string
     */
    private $answer;

    /**
     * @OA\Property(
     *     title="faq_tag",
     *     description="Тэг",
     *     format="object",
     *     example={}
     * )
     *
     * @var string
     */
    private $faq_tag;
}