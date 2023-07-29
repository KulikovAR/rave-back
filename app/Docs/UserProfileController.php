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
     *                                  @OA\Property(property="phone_prefix", type="string", example="+7"),
     *                                  @OA\Property(property="phone", type="string", example="123456789"),
     *                                  @OA\Property(property="country", type="string", example="RU"),
     *                                  @OA\Property(property="firstname", type="string", example="firstname"),
     *                                  @OA\Property(property="lastname", type="string", example="lastname"),
     *                                  @OA\Property(property="birthday", type="string", example="25.10.1922"),
     *                                  @OA\Property(property="gender", type="string", example="male"),
     *                                  @OA\Property(property="document_number", type="string", example="34343aaa4343"),
     *                                  @OA\Property(property="document_expires", type="string", example="25.10.2087"),
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
    public function index() {}

    /**
     *
     * @OA\Post(
     *     path="/user_profile",
     *     tags={"UserProfile"},
     *     operationId="create_profile",
     *     summary="Create or update profile",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="phone_prefix",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="+7"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=123456789
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="country",
     *          in="query",
     *          required=true,
     *          description = "Input country code: RU / US / GB",
     *          @OA\Schema(
     *              type="string",
     *              example="RU"
     *          )
     *     ),
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
     *     @OA\Parameter(
     *          name="birthday",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.1922"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="gender",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"male","female"}
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_number",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="34343aaa4343"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="document_expires",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="25.10.2087"
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
     *                                  @OA\Property(property="phone_prefix", type="string", example="+7"),
     *                                  @OA\Property(property="phone", type="string", example="123456789"),
     *                                  @OA\Property(property="country", type="string", example="RU"),
     *                                  @OA\Property(property="firstname", type="string", example="firstname"),
     *                                  @OA\Property(property="lastname", type="string", example="lastname"),
     *                                  @OA\Property(property="birthday", type="string", example="25.10.1922"),
     *                                  @OA\Property(property="gender", type="string", example="male"),
     *                                  @OA\Property(property="document_number", type="string", example="34343aaa4343"),
     *                                  @OA\Property(property="document_expires", type="string", example="25.10.2087"),
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
    public function store() {}
}
