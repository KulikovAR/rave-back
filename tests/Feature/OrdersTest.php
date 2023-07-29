<?php

namespace Tests\Feature;

use App\Enums\PassengerTypeEnum;
use App\Interfaces\FetchFlightInterface;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\User;
use App\Services\TripsFetcherService;
use Database\Factories\OrderPassengerFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    public function test_orders_with_promo_code_created_no_auth(): void
    {
        $this->makeXmlMock();

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson = json_encode($flightsArr[0]['to']);

        $passenger1Data = (new OrderPassengerFactory())->definitionRequest();

        $email = $this->faker->email;

        $promoCode = Promocode::first();

        $inputData = [
            'email'               => $email,
            'phone_prefix'        => '+7',
            'phone'               => $this->faker->numerify('#########'),
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'passengers'          => [$passenger1Data],
            'trip_to'             => $flightToJson,
            'trip_back'           => null,
            'promo_code'          => $promoCode->promo_code
        ];

        $response = $this->json('post', route('orders.store'), $inputData);
        $response->assertStatus(200);

        $responseData = $response->json()['data'];

        $order = Order::whereEmail($email)->first();
        $this->assertNotEmpty($order);
        $this->assertNotNull($order->promocode_id);

        $this->assertSame($responseData['discount'], $order->discount);
        $this->assertSame($responseData['commission'], $order->commission);
        $this->assertSame($responseData['promo_code'], $order->promo_code);
    }

    public function test_orders_with_passengers_created_no_auth(): void
    {
        $this->makeXmlMock('twice');

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson   = json_encode($flightsArr[0]['to']);
        $flightBackJson = json_encode($flightsArr[0]['back']);

        $passenger1Data = (new OrderPassengerFactory())->definitionRequest();
        $passenger2Data = (new OrderPassengerFactory())->definitionRequest();

        $email = $this->faker->email;

        $inputData = [
            'email'               => $email,
            'phone_prefix'        => '+7',
            'phone'               => $this->faker->numerify('#########'),
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'passengers'          => [$passenger1Data, $passenger2Data],
            'trip_to'             => $flightToJson,
            'trip_back'           => $flightBackJson,
            'hotel_city'          => 'Moscow',
            'hotel_check_in'      => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'hotel_check_out'     => $this->faker->dateTimeInInterval('+30 day')->format('d.m.Y'),

        ];

        $response = $this->json('post', route('orders.store'), $inputData);
        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertSame($email, $response['data']['email']);
        $this->assertNotEmpty($response['data']['price']);
        $this->assertNotEmpty($response['data']['order_number']);
        $this->assertSame($flightToJson, $responseData['data']['trip_to']);
        $this->assertSame(Order::CREATED, $responseData['data']['order_status']);
        $this->assertSame(Order::TYPE_NORMAL, $responseData['data']['order_type']);

        $this->assertCount(2, $response['data']['passengers']);

        unset($passenger1Data['type']);
        $passenger1Response = $response['data']['passengers'][0];
        unset($passenger1Response['id']);
        unset($passenger1Response['type']);

        $this->assertEquals($passenger1Data, $passenger1Response);


        $order = Order::whereEmail($email)->first();
        $this->assertNotEmpty($order);
        $this->assertNotEmpty($order->reservation_from_token);
        $this->assertNotEmpty($order->reservation_to_token);


        $passengers = $order->orderPassenger;
        $this->assertCount(2, $passengers);
    }

    public function test_orders_associate_with_auth_user(): void
    {
        $this->makeXmlMock('twice');

        $this->getTestUser()->order()->forceDelete();

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson   = json_encode($flightsArr[0]['to']);
        $flightBackJson = json_encode($flightsArr[0]['back']);

        $passenger1Data = (new OrderPassengerFactory())->definitionRequest();
        $passenger2Data = (new OrderPassengerFactory())->definitionRequest();

        $email = $this->faker->email;

        $inputData = [
            'email'               => $email,
            'phone_prefix'        => '+7',
            'phone'               => $this->faker->numerify('#########'),
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'passengers'          => [$passenger1Data, $passenger2Data],
            'trip_to'             => $flightToJson,
            'trip_back'           => $flightBackJson,
            'hotel_city'          => 'Moscow',
            'hotel_check_in'      => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'hotel_check_out'     => $this->faker->dateTimeInInterval('+30 day')->format('d.m.Y'),

        ];

        $response = $this->json('post', route('orders.store'), $inputData, $this->userBearerHeaders);

        $response->assertStatus(200);

        $totalOrders = $this->getTestUser()->order->count();
        $this->assertSame(1, $totalOrders);
    }

    public function test_orders_associate_with_users_email(): void
    {
        $this->makeXmlMock('twice');
        $this->getTestUser()->order()->forceDelete();

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson   = json_encode($flightsArr[0]['to']);
        $flightBackJson = json_encode($flightsArr[0]['back']);

        $passenger1Data = (new OrderPassengerFactory())->definitionRequest();
        $passenger2Data = (new OrderPassengerFactory())->definitionRequest();


        $inputData = [
            'email'               => UserSeeder::USER_EMAIL,
            'phone_prefix'        => '+7',
            'phone'               => $this->faker->numerify('#########'),
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'passengers'          => [$passenger1Data, $passenger2Data],
            'trip_to'             => $flightToJson,
            'trip_back'           => $flightBackJson,
            'hotel_city'          => 'Moscow',
            'hotel_check_in'      => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'hotel_check_out'     => $this->faker->dateTimeInInterval('+30 day')->format('d.m.Y'),

        ];

        $response = $this->json('post', route('orders.store'), $inputData);

        $response->assertStatus(200);


        $totalOrders = $this->getTestUser()->order->count();

        $this->assertSame(1, $totalOrders);
    }

    public function test_orders_update_no_auth(): void
    {
        $this->makeXmlMock();

        $order                         = $this->getTestUser()->order()->where(['order_status' => Order::CREATED])->first();
        $order->reservation_to_token   = null;
        $order->reservation_from_token = null;
        $order->save();

        $orderId     = $order->id;
        $orderNumber = $order->order_number;

        $email = UserSeeder::USER_EMAIL;

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::ADULT->value => 2]);

        $flightToJson = json_encode($flightsArr[0]['to']);

        $passenger1Data = (new OrderPassengerFactory())->definitionRequest();
        $passenger2Data = (new OrderPassengerFactory())->definitionRequest();

        $orderStartBooking = $this->faker->dateTimeInInterval('+10 day')->setTime(0, 0);

        $inputData = [
            'id'                  => $orderId,
            'order_number'        => $orderNumber,
            'email'               => $email,
            'phone_prefix'        => '+7',
            'phone'               => $this->faker->numerify('#########'),
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $orderStartBooking->format('d.m.Y'),
            'passengers'          => [$passenger1Data, $passenger2Data],
            'trip_to'             => $flightToJson,
            'hotel_city'          => 'Moscow1',
            'hotel_check_in'      => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'hotel_check_out'     => $this->faker->dateTimeInInterval('+30 day')->format('d.m.Y'),
        ];

        $response = $this->json('put', route('orders.update'), $inputData);

        $response->assertStatus(200);
        $response->json()['data'];

        $orderStartBookingDb = DB::table('orders')
                                 ->where([
                                             'email'        => UserSeeder::USER_EMAIL,
                                             'order_status' => Order::CREATED,
                                             'order_type'   => Order::TYPE_NORMAL
                                         ])
                                 ->first()->order_start_booking;

        $this->assertSame($orderStartBooking->format('Y-m-d H:i:s'), $orderStartBookingDb);


        $order = $this->getTestUser()->order()->first();
        $this->assertNotEmpty($order->reservation_to_token);
        $this->assertEmpty($order->reservation_from_token);

        $this->assertSame(1, $this->getTestUser()->order->count());
    }

    public function test_orders_index_auth_user()
    {
        $response = $this->json(
                     'get',
                     route('orders.index'),
            headers: $this->userBearerHeaders
        );
        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertNotEmpty($responseData);
    }

    public function test_orders_index_no_auth()
    {
        $response = $this->json('get', route('orders.index'));
        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertEmpty($responseData);
    }

    public function test_orders_show_auth_user()
    {
        $orderId = $this->getTestUser()->order->first()->id;

        $response = $this->json(
                     'get',
                     route('orders.index', ['id' => $orderId]),
            headers: $this->userBearerHeaders
        );

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertNotEmpty($responseData);
    }

    public function test_orders_show_to_no_auth()
    {
        $orderId = $this->getTestUser()->order->first()->id;

        $response = $this->json('get', route('orders.index', ['id' => $orderId]));

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertNotEmpty($responseData);
    }

    public function test_orders_passenger_type_generation(): void
    {
        $this->makeXmlMock();

        $email = UserSeeder::USER_EMAIL;
        $user  = User::whereEmail($email)->first();
        $user->order()->forceDelete();

        $flightsArr = TripsFetcherServiceTest::getFlightsArr([PassengerTypeEnum::INFANT->value => 1]);

        $flightToJson = json_encode($flightsArr[0]['to']);

        $passenger1Data             = (new OrderPassengerFactory())->definitionRequest();
        $passenger1Data['birthday'] = $this->faker->dateTimeInInterval('- 2 years')->format('d.m.Y');

        $inputData = [
            'email'               => $email,
            'order_type'          => Order::TYPE_NORMAL,
            'order_start_booking' => $this->faker->dateTimeInInterval('+1 day')->format('d.m.Y'),
            'passengers'          => [$passenger1Data],
            'trip_to'             => $flightToJson,
        ];

        $response = $this->json('post', route('orders.store'), $inputData);

        $response->assertStatus(200);

        $passengerType = $response->json('data')['passengers'][0]['type'];
        $this->assertSame(PassengerTypeEnum::INFANT->value, $passengerType);
    }

    public function test_orders_create_validation(): void
    {
        $inputData = [
            'order_type'          => 'bad_type',
            'order_start_booking' => $this->faker->dateTimeInInterval('-10 day')->format('d.m.Y'),
            'passengers'          => [],
            'trip_back'           => 'bad_json',
            'hotel_city'          => 'Moscow',
            'hotel_check_in'      => $this->faker->dateTimeInInterval('-10 day')->format('d.m.Y'),
            'hotel_check_out'     => $this->faker->dateTimeInInterval('-30 day')->format('d.m.Y'),

        ];

        $response = $this->json('post', route('orders.store'), $inputData);

        $response->assertStatus(422);

        $response->assertJsonStructure([
                                           'message',
                                           'errors' => [
                                               'email',
                                               'order_type',
                                               'order_start_booking',
                                               'passengers',
                                               'trip_to',
                                               'trip_back',
                                               'hotel_check_in',
                                               'hotel_check_out',
                                           ]
                                       ]);

    }

    private function makeXmlMock($countTimes = 'once')
    {
        $BookingResponseFile = file_get_contents(base_path() . '/tests/src/portBiletSelectBooking.xml');
        $mock                = Mockery::mock(TripsFetcherService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive(['requestBooking' => $BookingResponseFile])->$countTimes();
        $this->instance(FetchFlightInterface::class, $mock);
    }
}
