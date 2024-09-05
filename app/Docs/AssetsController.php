<?php

namespace App\Docs;

class AssetsController
{
    /**
     * @OA\Get(
     *     path="/assets/{locale}",
     *     tags={"Assets"},
     *     operationId="index_assets",
     *     summary="Tel codes, flags, countries, etc",
     *
     *     @OA\Parameter(
     *          name="locale",
     *          in="path",
     *          description="Can specify language: ru, en... (optional)",
     *
     *          @OA\Schema(
     *              type="string",
     *              enum={"ru","en"}
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *      ),
     * )
     */
    public function index() {}
}
