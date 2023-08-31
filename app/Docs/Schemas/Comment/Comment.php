<?php

namespace App\Docs\Schemas\Comment;

/**
 * @OA\Schema(
 *     title="Comment",
 *     description="Comment model",
 *     @OA\Xml(
 *         name="Comment"
 *     )
 * )
 */

class Comment
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id комментария",
     *     format="string",
     *     example="99cf5f65-ad91-4b43-9cb7-88088e92ea68"
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     title="body",
     *     description="Текст комментария",
     *     format="string",
     *     example="В этом уроке мы рассмотрим графический дизайн, который включает создание логотипов, иллюстраций, макетов и других графических элементов. Вы узнаете о принципах композиции, цветовой теории и использовании графических инструментов."
     * )
     *
     * @var string
     */
    private $body;


    /**
     * @OA\Property(
     *     title="user",
     *     description="Пользователь",
     *     format="object",
     *     example={}
     * )
     *
     * @var string
     */
    private $user;
}