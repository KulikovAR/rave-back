<?php

namespace App\Services;

use App\Enums\EnvironmentTypeEnum;
use App\Interfaces\PaymentServiceInterface;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Log;

class TinkoffPaymentService implements PaymentServiceInterface
{
    const URL_PAYMENT       = 'https://securepay.tinkoff.ru/v2/Init';
    const UPD_SUBSCRIPTION  = 'https://securepay.tinkoff.ru/v2/Charge';
    const URL_PAYMENT_STATE = 'https://securepay.tinkoff.ru/v2/GetState';

    public function getPaymentUrl(Order $order): array
    {
        $priceTotal = $order->price * 100;

        $requestData = [
            "TerminalKey"     => config('tinkoff-payment.terminal'),
            "NotificationURL" => route('payment.status'),
            "SuccessURL"      => route('payment.success', ['id' => $order->id]),
            "FailURL"         => route('payment.failed', ['id' => $order->id]),
            "Amount"          => $priceTotal,
            "OrderId"         => $order->id,
            "Recurrent"       => "Y",
            "CustomerKey"     => $order->user->id,
            "Description"     => "Оплата подписки на TrueSchool",
            "DATA"            => [
                "DefaultCard" => "none"
            ],
            "Receipt"         => [
                "Email"        => config('site-values.email_support.email_support'),
                "Phone"        => config('site-values.phone_support.phone_support'),
                "EmailCompany" => config('site-values.email_support.email_support'),
                "Taxation"     => "patent",
                "Items"        => [
                    [
                        "Name"          => "Оплата подписки на TrueSchool",
                        "Price"         => $priceTotal,
                        "Quantity"      => 1.00,
                        "Amount"        => $priceTotal * 1,
                        "PaymentMethod" => "full_prepayment",
                        "Tax"           => "none",
                    ],
                ]
            ]
        ];

        $responseArr = $this->makeRequest($requestData, self::URL_PAYMENT);

        $paymentUrl = ($responseArr['Success'] ?? null)
            ? $responseArr['PaymentURL']
            : config('front-end.payment_failed')
            . $order->id
            . config('front-end.payment_status_failed')
            . ($responseArr['Message'] ?? '')
            . ($responseArr['Details'] ?? '');

        $paymentId = $responseArr['PaymentId'] ?? null;

        return [$paymentUrl, $paymentId];
    }

    public function getPaymentState(Order $order): array
    {
        $requestData = [
            "TerminalKey" => config('tinkoff-payment.terminal'),
            "PaymentId"   => $order->payment_id,
        ];

        $responseArr = $this->makeRequest($requestData, self::URL_PAYMENT_STATE);

        $paymentSuccessState = $responseArr['Success'];
        $paymentAmount       = $responseArr['Amount'] ?? null;

        return [$paymentSuccessState, $paymentAmount];
    }

    public function updateSubscription(Order $order): array
    {
        $requestData = [
            "TerminalKey" => config('tinkoff-payment.terminal'),
            "PaymentId"   => $order->payment_id,
            "RebillId"    => $order->rebill_id,
            "SendEmail"   => true,
            "InfoEmail"   => $order->user->email,
        ];

        $responseArr = $this->makeRequest($requestData, self::UPD_SUBSCRIPTION);

        $paymentSuccessState = $responseArr['Success'];
        $paymentAmount       = $responseArr['Amount'] ?? null;

        return [$paymentSuccessState, $paymentAmount];
    }

    protected function makeRequest(array $requestData, string $url): array
    {
        $response = Http::withOptions(['verify' => false, 'allow_redirects' => true])
                        ->withBody(json_encode($requestData + $this->getSignToken($requestData)), 'application/json')
                        ->post($url);

        $responseJson = $response->json();

        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            Log::info($responseJson);
        }

        return $responseJson;
    }

    private function getSignToken(array $args): array
    {
        $token = '';

        $args['Password'] = config('tinkoff-payment.secret');

        ksort($args);

        foreach ($args as $arg) {
            if (!is_array($arg)) {
                $token .= $arg;
            }
        }
        $signToken = hash('sha256', $token);

        return ['Token' => $signToken];
    }
}