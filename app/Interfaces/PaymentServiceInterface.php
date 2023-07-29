<?php

namespace App\Interfaces;

use App\Models\Order;

interface PaymentServiceInterface
{
    public function getPaymentUrl(Order $order): array;

}