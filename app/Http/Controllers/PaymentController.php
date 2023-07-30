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

        return redirect(config('front-end.payment_success') . $order->id);
    }

    public function failed(UuidRequest $request)
    {
        $order               = Order::where(['order_status' => Order::CREATED])->findOrFail($request->id);
        $order->order_status = Order::CANCELED;
        $order->save();

        $message = 'Payment failed! ' . 'OrderId:' . $order->id;
        Log::info($message);
        NotificationService::notifyAdmin($message);

        return redirect(
            config('front-end.payment_failed')
            . $order->id
            . config('front-end.payment_status_failed')
            . __('order.payment_error')
        );
    }
}
