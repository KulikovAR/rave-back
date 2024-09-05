<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function getPaymentUrl(Order $order): array;

    public function getPaymentState(Order $order): array;
}