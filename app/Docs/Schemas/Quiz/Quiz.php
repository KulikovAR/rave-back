<?php

namespace App\Docs\Schemas\Quiz;

/**
 * @OA\Schema(
 *     title="Quiz",
 *     description="Quiz model",
 *     @OA\Xml(
 *         name="Quiz"
 *     )
 * )
 */

class Quiz
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
     *     description="Название квиза",
     *     format="string",
     *     example="Новый урок"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="description",
     *     description="Описание квиза",
     *     format="string",
     *     example="В этом уроке мы рассмотрим графический дизайн, который включает создание логотипов, иллюстраций, макетов и других графических элементов. Вы узнаете о принципах композиции, цветовой теории и использовании графических инструментов."
     * )
     *
     * @var string
     */
    private $description;



    /**
     *  @OA\Property(property="data", type="object", example={}
     *   )
     *
     * @var string
     */
    private $data;

}