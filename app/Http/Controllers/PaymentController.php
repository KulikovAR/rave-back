<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Interfaces\PaymentServiceInterface;
use App\Services\NotificationService;
use App\Services\TinkoffPaymentService;
use Log;

class PaymentController extends Controller
{
    public function __construct(
        public PaymentServiceInterface $paymentService = new TinkoffPaymentService(),
    ) {}

    //TODO add orders Model
    //TODO fix filament and csrf
    //TODO fix output of user resource
    //TODO check and rename Json RESPONSE and others
    public function redirect(UuidRequest $request)
    {
        $order = Order::where(['order_status' => Order::CREATED])->findOrFail($request->id);

        list($paymentUrl, $paymentId) = $this->paymentService->getPaymentUrl($order);

        if (empty($paymentId)) {
            Log::alert('OrderId:' . $order->id . ' No payment url. Check payment provider');
            return redirect($paymentUrl);
        }

        $order->payment_id = $paymentId;
        $order->save();

        return redirect($paymentUrl);
    }

    public function success(UuidRequest $request)
    {
        $order = Order::where(['order_status' => Order::CREATED])->findOrFail($request->id);

        list($paymentSuccess, $paymentAmount) = $this->paymentService->getPaymentState($order);

        $cents      = 100;
        $priceTotal = ($order->price - $order->discount) * $cents;

        if ($paymentSuccess !== true || $priceTotal < $paymentAmount) {
            $message = 'OrderId: ' . $order->id . ' Payment status failed or small payed amount. Payment/Amount: ' . $paymentSuccess . ' / ' . $paymentAmount;
            Log::alert($message);
            NotificationService::notifyAdmin($message);

            return redirect(
                config('front-end.payment_failed')
                . $order->id
                . config('front-end.payment_status_failed')
                . __('order.payment_failed')
            );
        }

        $order->order_status = Order::PAYED;
        $order->save();

        list($bookingNumberTo, $bookingNumberFrom, $errorMsg) = $this->bookFlights($order);

        $order->flight_to_booking_id   = $bookingNumberTo;
        $order->flight_from_booking_id = $bookingNumberFrom;
        $order->save();

        if (empty($errorMsg) === false) {
            return redirect(
                config('front-end.payment_failed')
                . $order->id
                . config('front-end.booking_failed')
                . $errorMsg
            );
        }


        event(new BookFlightEvent($order));

        return redirect(config('front-end.payment_success') . $order->id);
    }

    public function retry(UuidRequest $request)
    {
        $order = Order::where(['order_status' => Order::PAYED])->findOrFail($request->id);


        list($bookingNumberTo, $bookingNumberFrom, $errorMsg) = $this->bookFlights($order);

        $order->flight_to_booking_id   = $bookingNumberTo;
        $order->flight_from_booking_id = $bookingNumberFrom;
        $order->save();

        if (empty($errorMsg) === false) {
            return redirect(
                config('front-end.payment_failed')
                . $order->id
                . config('front-end.booking_failed')
                . $errorMsg
            );
        }

        return redirect(config('front-end.payment_success') . $order->id);
    }

    public function failed(UuidRequest $request)
    {
        $order               = Order::where(['order_status' => Order::CREATED])->findOrFail($request->id);
        $order->order_status = Order::CANCELED;
        $order->save();

        Log::info('Payment failed! ' . 'OrderId:' . $order->id);

        return redirect(
            config('front-end.payment_failed')
            . $order->id
            . config('front-end.payment_status_failed')
            . __('order.payment_error')
        );
    }

    public function download(UuidRequest $request)
    {
        $order = Order::where(['order_status' => Order::PAYED])->findOrFail($request->id);

        return $this->pdfService->createBooking($order, 'download', $this->xmlParserService, $this->fetchFlightService);
    }

    private function bookFlights($order): array
    {
        $flightBackArr = json_decode($order->trip_back, 'true') ?? [];

        $bookingNumberTo = null;
        if (!empty($order->reservation_to_token) && empty($order->flight_to_booking_id)) {
            $bookingReservationXml = $this->fetchFlightService->makeBooking($order->reservation_to_token, $order);
            $bookingNumberTo       = $this->xmlParserService->parseBookingNumber($bookingReservationXml);

        }

        $bookingNumberFrom = null;
        if (!empty($order->reservation_from_token) && empty($order->flight_from_booking_id)) {
            $bookingReservationXml = $this->fetchFlightService->makeBooking($order->reservation_from_token, $order);
            $bookingNumberFrom     = $this->xmlParserService->parseBookingNumber($bookingReservationXml);
        }

        if ($bookingNumberTo === null) {
            $message = 'OrderId: ' . $order->id . ' No "TO" booking number. Money back needed!';
            Log::alert($message);
            NotificationService::notifyAdmin($message);
        }

        if (!empty($flightBackArr) && $bookingNumberFrom === null) {
            $message = 'OrderId: ' . $order->id . ' No "BACK" booking number. Money back needed!';
            Log::alert($message);
            NotificationService::notifyAdmin($message);
        }

        $errorMsg = $this->getResponseMsg($flightBackArr, $bookingNumberTo, $bookingNumberFrom);

        return [$bookingNumberTo, $bookingNumberFrom, $errorMsg];
    }

    private function getResponseMsg(?array $flightBackArr, ?string $reservationToToken, ?string $reservationFromToken): ?string
    {
        if (empty($reservationToToken) && empty($reservationFromToken)) {
            return __('order.flight_service_error');
        }

        if (!empty($flightBackArr) && empty($reservationFromToken)) {
            return __('order.flight_back_expired');
        }

        return null;
    }
}
