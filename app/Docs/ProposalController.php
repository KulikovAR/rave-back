<?php

namespace App\Docs;


class ProposalController
{
    /**
     *
     * @OA\Post(
     *     path="/proposal",
     *     tags={"Proposal"},
     *     operationId="create_proposal",
     *     summary="Create or update proposal",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="body",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Новая идея для видеоролика"
     *          )
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example="Created"),
     *                @OA\Property(property="data", type="object",
     *                                  @OA\Property(property="body", type="string", example="Новая идея для видеоролика"),
     *                                  @OA\Property(property="file", type="string", example="http://127.0.0.1:8000/proposal/q8Ft0bOlR3Yv9npwfwydzG5f4aD6Ybt9PV5HL5uX.png"),        
     *                ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *      ),
     *     @OA\Response(
     *          response="403",
     *          ref="#/components/responses/403"
     *      ),
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/401"
     *      ),
     * )
     *
     *
     */
    public function store()
    {
    }
}