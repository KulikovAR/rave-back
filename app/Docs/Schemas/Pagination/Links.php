<?php

namespace App\Docs\Schemas\Pagination;

/**
 * @OA\Schema(
 *     title="Links",
 *     description="Links schema",
 *     @OA\Xml(
 *         name="Links"
 *     )
 * )
 */

class Links
{
    /**
     * @OA\Property(
     *     title="first_page_url",
     *     description="first_page_url",
     *     format="string",
     *     example="http://127.0.0.1:8000/api/v1/lessons?page=1"
     * )
     *
     * @var string
     */
    private $first_page_url;

    /**
     * @OA\Property(
     *     title="prev_page_url",
     *     description="prev_page_url",
     *     format="string",
     *     example="http://127.0.0.1:8000/api/v1/lessons?page=1"
     * )
     *
     * @var string
     */
    private $prev_page_url;

    /**
     * @OA\Property(
     *     title="next_page_url",
     *     description="next_page_url",
     *     format="string",
     *     example="http://127.0.0.1:8000/api/v1/lessons?page=1"
     * )
     *
     * @var string
     */
    private $next_page_url;

    /**
     * @OA\Property(
     *     title="last_page_url",
     *     description="last_page_url",
     *     format="string",
     *     example="http://127.0.0.1:8000/api/v1/lessons?page=1"
     * )
     *
     * @var string
     */
    private $last_page_url;
}