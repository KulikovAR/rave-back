<?php

namespace App\Docs;


class UserProfileController
{
    /**
     *
     * @OA\Get(
     *     path="/user_profile",
     *     tags={"UserProfile"},
     *     operationId="index_profile",
     *     summary="View profile",
     *     security={{"api": {}}},
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example="Created"),
     *                @OA\Property(property="data", type="object",
     *                              @OA\Property(property="user", type="object",
     *                                  @OA\Property(property="id", type="integer", example="9976801b-6070-4357-bab2-fb47219dad57"),
     *                                  @OA\Property(property="email", type="string", example="test@test.ru"),
     *                              ),
     *                              @OA\Property(property="profile", type="object",
     *                                  @OA\Property(property="firstname", type="string", example="firstname"),
     *                                  @OA\Property(property="lastname", type="string", example="lastname"),
     *                              ),
     *                ),
     *             ),
     *         )
     *     ),
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
    public function index()
    {
    }

    /**
     *
     * @OA\Post(
     *     path="/user_profile",
     *     tags={"UserProfile"},
     *     operationId="create_profile",
     *     summary="Create or update profile",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="firstname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="firstname"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="lastname"
     *          )
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
     *                                  @OA\Property(property="firstname", type="string", example="firstname"),
     *                                  @OA\Property(property="lastname", type="string", example="lastname"),        
     *                                  @OA\Property(property="avatar", type="string", example="http://127.0.0.1:8000/avatars/q8Ft0bOlR3Yv9npwfwydzG5f4aD6Ybt9PV5HL5uX.png"),        
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


    /**
     *
     * @OA\Post(
     *     path="/user_profile/avatar",
     *     tags={"UserProfile"},
     *     operationId="create_avatar_profile",
     *     summary="Create or update avatar profile",
     *     security={{"api": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 required={"avatar"}
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
     *                                  @OA\Property(property="firstname", type="string", example="firstname"),
     *                                  @OA\Property(property="lastname", type="string", example="lastname"),        
     *                                  @OA\Property(property="avatar", type="string", example="http://127.0.0.1:8000/avatars/q8Ft0bOlR3Yv9npwfwydzG5f4aD6Ybt9PV5HL5uX.png"),        
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
    public function storeAvatar()
    {
    }
}