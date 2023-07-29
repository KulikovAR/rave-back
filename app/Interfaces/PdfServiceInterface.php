<?php

namespace App\Interfaces;

use App\Models\Order;

interface PdfServiceInterface
{
    public function createBooking(
        Order                $order,
        string               $method,
        XmlParserInterface   $xmlParserService,
        FetchFlightInterface $fetchFlightService
    );
}