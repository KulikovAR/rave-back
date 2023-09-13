<?php

namespace Tests\Feature;

use App\Interfaces\PaymentServiceInterface;
use App\Models\Order;
use App\Services\TinkoffPaymentService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function test_payments_redirect_get_payment_url()
    {

        $mockResponseArr = [
            "Success"     => true,
            "ErrorCode"   => "0",
            "TerminalKey" => "1688458884133DEMO",
            "Status"      => "NEW",
            "PaymentId"   => "2989815346",
            "OrderId"     => "21050",
            "Amount"      => 149900,
            "PaymentURL"  => "https://securepayments.tinkoff.ru/z2YCRsJz",
        ];

        $user = $this->getTestUser();
        $user->orders()->delete();
        $userId = $user->id;

        $mock = Mockery::mock(TinkoffPaymentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['makeRequest' => $mockResponseArr])->once();
        $this->instance(PaymentServiceInterface::class, $mock);

        $response = $this->json('get',
                                route('payment.redirect', [
                                    'id' => $userId, 'order_type' => Order::NORMAL
                                ])
        );

        $response->assertStatus(302);

        $this->assertNotEmpty($user->orders->first()?->payment_id);
    }

    public function test_payments_success()
    {
        Notification::fake();

        $user  = $this->getTestUser();
        $order = $user->orders()->create([
                                             'order_status' => Order::CREATED,
                                             'order_type'   => Order::NORMAL,
                                             'duration'     => 30,
                                             'price'        => 300,
                                             'payment_id'   => '1231456478',
                                         ]);

        $mockResponseArr = [
            "Success"     => true,
            "ErrorCode"   => "0",
            "TerminalKey" => "1688458884133DEMO",
            "Status"      => "CONFIRMED",
            "PaymentId"   => "2989815346",
            "OrderId"     => $order->id,
            "Amount"      => ($order->price) * 100,
        ];


        $mock = Mockery::mock(TinkoffPaymentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['makeRequest' => $mockResponseArr])->once();
        $this->instance(PaymentServiceInterface::class, $mock);

        $response = $this->json('get', route('payment.success'), ['id' => $order->id]);
        $response->assertStatus(302);

        $this->assertTrue($order->refresh()->order_status === Order::PAYED);

//        Notification::assertSentTimes(BookingFlightNotification::class, 1);

    }

    public function test_payments_unsubscribe()
    {
        $this->getTestUser()
             ->orders()
             ->create([
                          'price'        => 1,
                          'duration'     => 1,
                          'order_status' => Order::PAYED,
                          'order_type'   => Order::NORMAL,
                      ]);
        $this->assertNotEmpty($this->getTestUser()->orders);

        $response = $this->json('delete',
                                route('payment.unsubscribe'), headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $this->assertEmpty($this->getTestUser()->orders);
        $this->assertSame($this->getTestUser()->auto_subscription, false);
    }

    public function test_payments_request()
    {

        $this->markTestSkipped();

        $requestData = [
            "TerminalKey" => config('tinkoff-payment.terminal'),
            "SuccessURL"  => config('front-end.payment_success'),
            "FailURL"     => config('front-end.payment_failed'),
            "Amount"      => 1499 * 100,
            "OrderId"     => "21050",
            "Recurrent"   => "Y",
            "CustomerKey" => "dsds",
            "Description" => "Бронирование airsurfer+",
            "DATA"        => [
                "DefaultCard" => "none"
            ],
            "Receipt"     => [
                "Email"        => "a@test.ru",
                //"Phone"        => "+79031234567",
                "EmailCompany" => config('site-values.email_support.email_support'),
                "Taxation"     => "osn",
                "Items"        => [
                    [
                        "Name"          => "Наименование товара 1",
                        "Price"         => 1499 * 100,
                        "Quantity"      => 1.00,
                        "Amount"        => 1499 * 100 * 1,
                        "PaymentMethod" => "full_prepayment",
                        "Tax"           => "vat10",
                    ],
                ]
            ]
        ];

        $tokenArr = ["Token" => $this->genToken($requestData)];

        $response = Http::withBody(json_encode($requestData + $tokenArr), 'application/json')
                        ->post('https://securepay.tinkoff.ru/v2/Init');

        dd($response->json());
    }

    public function test_get_payment_status_request()
    {

        $this->markTestSkipped();

        $requestData = [
            "TerminalKey" => config('tinkoff-payment.terminal'),
            "PaymentId"   => "3231008477",
            "IP"          => "127.0.0.1",
        ];

        $tokenArr = ["Token" => $this->genToken($requestData)];

        $response = Http::withBody(json_encode($requestData + $tokenArr), 'application/json')
                        ->post(TinkoffPaymentService::URL_PAYMENT_STATE);

        dd($response->json());
    }

    public function test_payment_status_webhook()
    {
        $inputData = [
            "TerminalKey" => "1688458884133DEMO",
            "OrderId"     => "9a1bf3f8-7a52-4775-85a4-57a1b5344b6e",
            "Success"     => 1,
            "Status"      => "CONFIRMED",
            "PaymentId"   => 3231391205,
            "ErrorCode"   => 0,
            "Amount"      => 150000,
            "CardId"      => 330622349,
            "Pan"         => "430000******0777",
            "ExpDate"     => 1122,
            "RebillId"    => 1694447045829,
            "Token"       => "b9af0485d694fa057c386474e3ced9e6aea00c3ca85a507f7f7a546256a803a3"
        ];
    }

    private function genToken($args)
    {
        $token            = '';
        $args['Password'] = config('tinkoff-payment.secret');
        ksort($args);

        foreach ($args as $arg) {
            if (!is_array($arg)) {
                $token .= $arg;
            }
        }
        return hash('sha256', $token);
    }
}
