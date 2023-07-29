<?php

namespace App\Services;

use App\Interfaces\FetchFlightInterface;
use App\Interfaces\PdfServiceInterface;
use App\Interfaces\XmlParserInterface;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService implements PdfServiceInterface
{
    public function createBooking(
        Order                $order,
        string               $method,
        XmlParserInterface   $xmlParserService,
        FetchFlightInterface $fetchFlightService
    )
    {
        $method = strtolower($method);

        if (in_array($method, ['save', 'download'], true) === false) {
            throw new \LogicException('Method should be: SAVE or DOWNLOAD');
        }


        $flightToXml   = $fetchFlightService->getStatusBooking($order->flight_to_booking_id);
        $flightFromXml = $fetchFlightService->getStatusBooking($order->flight_from_booking_id);

        //$flightToXml = file_get_contents(base_path() . '/portBiletManyBookingResponse.xml');
        //$flightFromXml = file_get_contents(base_path() . '/portBiletManyBookingResponse.xml');

        $data = ['flights' => [
            $xmlParserService->parseBooking($flightToXml),
            $xmlParserService->parseBooking($flightFromXml)
        ]];

        return Pdf::loadView('myPDF', $data)
                  ->setPaper('a4', 'portrait')
                  ->setWarnings(false)
                  ->$method(storage_path() . "/bookings/{$order->id}.pdf");
    }

}