<?php

namespace Tests\Feature;

use App\Events\BookFlightEvent;
use App\Interfaces\FetchFlightInterface;
use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\PdfServiceInterface;
use App\Models\Order;
use App\Notifications\BookingFlightNotification;
use App\Services\PdfService;
use App\Services\TinkoffPaymentService;
use App\Services\TripsFetcherService;
use Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function test_payments_get_payment_url()
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

        $order = Order::first();
        $order->update(['payment_id' => null, 'order_status' => Order::CREATED]);

        $orderId = $order->id;
        $this->assertEmpty($order->payment_id);

        $mock = Mockery::mock(TinkoffPaymentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['makeRequest' => $mockResponseArr])->once();
        $this->instance(PaymentServiceInterface::class, $mock);

        $response = $this->json('get', route('payment.redirect', ['id' => $orderId]));
        $response->assertStatus(302);

        $this->assertNotEmpty($order->fresh()->payment_id);
    }

    public function test_payments_success_booking_pdf_saved()
    {

        Notification::fake();

        $order = Order::factory()
                      ->create([
                                   'order_status'           => Order::CREATED,
                                   'flight_to_booking_id'   => null,
                                   'flight_from_booking_id' => null,
                                   'reservation_to_token'   => $this->faker->word,
                                   'reservation_from_token' => $this->faker->word
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

        $BookingResponseFile = file_get_contents(base_path() . '/tests/src/portBiletBookingResponse.xml');
        $mock                = Mockery::mock(TripsFetcherService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['makeBooking' => $BookingResponseFile])->twice();
        $this->instance(FetchFlightInterface::class, $mock);

        $response = $this->json('get', route('payment.success'), ['id' => $order->id]);
        $response->assertStatus(302);

        $this->assertTrue($order->refresh()->order_status === Order::PAYED);
        //$this->assertNotEmpty($order->refresh()->payment_id );
        $this->assertNotEmpty($order->refresh()->flight_to_booking_id);
        $this->assertNotEmpty($order->refresh()->flight_from_booking_id);

        Notification::assertSentTimes(BookingFlightNotification::class, 1);
        $this->assertFileExists(storage_path() . "/bookings/{$order->id}.pdf");

        unlink(storage_path() . "/bookings/{$order->id}.pdf");
    }

    public function test_payments_download_pdf()
    {
        $order = Order::factory()->create(['order_status' => Order::PAYED]);

        $xmlFile = file_get_contents(base_path() . '/tests/src/portBiletBookingCanceled.xml');
        $mock    = Mockery::mock(TripsFetcherService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['getStatusBooking' => $xmlFile])->twice();
        $this->instance(FetchFlightInterface::class, $mock);

        $response = $this->json('get', route('payment.download'), ['id' => $order->id]);

        $response->assertStatus(200);
        $this->assertSame("application/pdf", ($response->headers)->get('content-type'));
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
