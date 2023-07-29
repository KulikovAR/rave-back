<?php

namespace App\Docs;

class PartnerMessageController
{
    /**
     * @OA\Post(
     *     path="/partners/message",
     *     operationId="send_partner_msg",
     *     tags={"Partners"},
     *     summary="send partner request",
     *     security={{"api": {}}},
     *     @OA\Parameter(
     *          name="partner_url_location",
     *          in="query",
     *          required=true,
     *          description="Место расположения ссылки",
     *          @OA\Schema(
     *              type="string",
     *              example="YouTube channel Cats"
     *          )
     *     ),
     *
     *
     *     @OA\Parameter(
     *          name="take_out_type",
     *          in="query",
     *          required=true,
     *          description="Вывод по реквизитам/карте",
     *          @OA\Schema(
     *              type="string",
     *              enum={"credit-card","bank"}
     *          )
     *     ),
     *
     *
     *     @OA\Parameter(
     *          name="card_number",
     *          in="query",
     *          required=true,
     *          description="Номер карты",
     *          @OA\Schema(
     *              type="number",
     *              example=12345678910
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="card_bank_name",
     *          in="query",
     *          required=true,
     *          description="Название банка держателя карты",
     *          @OA\Schema(
     *              type="string",
     *              example="Tinkoff"
     *          )
     *     ),
     *
     *
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
}