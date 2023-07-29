<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function getPaymentUrl(Order $order): array;
}