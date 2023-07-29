<?php

namespace App\Docs;

class BankController
{
    /**
     * @OA\Get(
     *     path="/partners/bank",
     *     operationId="create_bank",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description = "pagination page number",
     *          @OA\Schema(
     *              type="number",
     *              example = 1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="data", type="object", example="[]"),
     *                @OA\Property(property="links", type="object", example="{}"),
     *                @OA\Property(property="meta", type="object", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/partners/bank",
     *     operationId="Post-bank",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="org_inn",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_kpp",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_ogrn",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_name",
     *          in="query",
     *          required=true,
     *          description="Название ООО",
     *          @OA\Schema(
     *              type="string",
     *              example="My organization"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_address",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Москва, Кремль, д.1"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_location",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *
     *
     *     @OA\Parameter(
     *          name="contact_fio",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Иван Иваныч"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_job",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Директор"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="email@email.ru"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_tel",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="+71234445566"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_bik",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=45646
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_user_account",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=456446456456464656
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_account",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=79879846131254646546
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_name",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Tinkoff"
     *          )
     *     ),
     *
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/partners/bank",
     *     operationId="Put-bank",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description="model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_inn",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_kpp",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_ogrn",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_name",
     *          in="query",
     *          required=true,
     *          description="Название ООО",
     *          @OA\Schema(
     *              type="string",
     *              example="My organization"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_address",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Москва, Кремль, д.1"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="org_location",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *
     *
     *     @OA\Parameter(
     *          name="contact_fio",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Иван Иваныч"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_job",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Директор"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="email@email.ru"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="contact_tel",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="+71234445566"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_bik",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=45646
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_user_account",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=456446456456464656
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_account",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="number",
     *              example=79879846131254646546
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="bank_name",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              example="Tinkoff"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/partners/bank",
     *     operationId="Delete-bank",
     *     tags={"Partners"},
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description = "model id",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                @OA\Property(property="status", type="string", example="OK"),
     *                @OA\Property(property="message", type="string", example=""),
     *                @OA\Property(property="data", example="{}"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          ref="#/components/responses/422"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          ref="#/components/responses/404"
     *     ),
     * )
     *
     */
    public function destroy() {}
}