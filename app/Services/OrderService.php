<?php

namespace App\Services;

use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Interfaces\FetchFlightInterface;
use App\Interfaces\XmlParserInterface;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function saveOrderWithPassengers(
        StoreOrderRequest|UpdateOrderRequest $request,
        array                                $passengersArr,
        ?Promocode                           $promoCode = null
    ): array
    {

        $price      = $this->calculatePrice($passengersArr, $request->order_type, $request->hotel_city);
        $discount   = ceil($price * ($promoCode?->discount ?? 0) / 100);
        $commission = ceil($price * ($promoCode?->commission ?? 0) / 100);

        DB::beginTransaction();

        $order = Order::create([
                                   'email'        => $request->email,
                                   'phone_prefix' => $request->phone_prefix,
                                   'phone'        => $request->phone,
                                   'comment'      => $request->comments,

                                   'trip_to'   => $request->trip_to,
                                   'trip_back' => $request->trip_back,

                                   'hotel_city'      => $request->hotel_city,
                                   'hotel_check_in'  => $request->hotel_check_in,
                                   'hotel_check_out' => $request->hotel_check_out,

                                   'order_type'          => $request->order_type,
                                   'order_start_booking' => $request->order_start_booking,
                                   'order_status'        => Order::CREATED,
                                   'order_number'        => substr(time(), -5),

                                   'promocode_id' => $promoCode?->id,
                                   'promo_code'   => $promoCode?->promo_code,
                                   'commission'   => $commission,
                                   'discount'     => $discount,
                                   'price'        => $price - $discount,
                               ]);


        $passengers = $order->orderPassenger()->createMany($passengersArr);

        DB::commit();

        return [$order, $passengers];
    }

    public function isOrderMadeByExistingUser(string $email, Order $order): void
    {
        $user = request()->user('sanctum') ?? User::whereEmail($email)->first();

        if ($user === null) {
            return;
        }

        $order->user()->associate($user);
        $order->save();
    }

    public function reserveBooking(StoreOrderRequest $request, FetchFlightInterface $fetchFlightService, XmlParserInterface $xmlParserService): array
    {
        $flightToArr   = json_decode($request->trip_to, 'true') ?? [];
        $flightBackArr = json_decode($request->trip_back, 'true') ?? [];

        $BookingRequestXml = $fetchFlightService->requestBooking($flightToArr, $request->passengers);
        $reserveToToken    = $xmlParserService->parseBookingToken($BookingRequestXml);
        $reserveBackToken  = null;

        if (!empty($flightBackArr)) {
            $BookingRequestXml = $fetchFlightService->requestBooking($flightBackArr, $request->passengers);
            $reserveBackToken  = $xmlParserService->parseBookingToken($BookingRequestXml);
        }

        $this->validateTokens($flightBackArr, $reserveToToken, $reserveBackToken);

        return [$reserveToToken, $reserveBackToken];
    }

    private function calculatePrice(
        array      $passengers,
        string     $orderType,
        ?string    $isHotelBooking = null,
        ?Promocode $promoCode = null
    ): int
    {
        $price = $orderType === Order::TYPE_NORMAL
            ? Order::PRICE_NORMAL
            : Order::PRICE_VIP;

        $totalPrice = count($passengers) * $price;

        if ($isHotelBooking) {
            $totalPrice += Order::PRICE_HOTEL;
        }

        return $totalPrice;

    }

    private function validateTokens(
        ?array  $flightBackArr,
        ?string $reservationToToken,
        ?string $reservationFromToken): void
    {
        if (empty($reservationToToken)) {
            abort(503, __('order.flight_expired'));
        }

        if (!empty($flightBackArr) && empty($reservationFromToken)) {
            abort(503, __('order.flight_back_expired'));
        }
    }
}