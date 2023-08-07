<?php

namespace App\Docs\Schemas\Pagination;

/**
 * @OA\Schema(
 *     title="Meta",
 *     description="Meta schema",
 *     @OA\Xml(
 *         name="Meta"
 *     )
 * )
 */

class Meta
{
    /**
     * @OA\Property(
     *     title="current_page",
     *     description="current_page",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $current_page;

    /**
     * @OA\Property(
     *     title="last_page",
     *     description="last_page",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $last_page;


    /**
     * @OA\Property(
     *     title="per_page",
     *     description="per_page",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $per_page;


    /**
     * @OA\Property(
     *     title="total",
     *     description="total",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $total;

    /**
     * @OA\Property(
     *     title="path",
     *     description="path",
     *     format="string",
     *     example="http://127.0.0.1:8000"
     * )
     *
     * @var string
     */
    private $prev_page_url;
}