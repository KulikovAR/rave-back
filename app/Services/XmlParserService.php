<?php

namespace App\Services;

use App\Enums\PassengerTypeEnum;
use App\Interfaces\XmlParserInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class XmlParserService implements XmlParserInterface
{
    public function parse(?string $xmlString): array
    {
        if (empty($xmlString)) {
            return [];
        }

        $xmlObject = simplexml_load_string($xmlString);
        $xmlObject->registerXPathNamespace('searchFlightsResponse', 'http://ws2.vip.server.xtrip.gridnine.com/');
        $messages = $xmlObject->xpath("//messages");
        $flights  = $xmlObject->xpath("//flights");
        $flight   = $xmlObject->xpath("//flight");

        return compact('flights', 'messages', 'flight');
    }

    public function parseBooking(?string $xmlString): array
    {
        if (empty($xmlString)) {
            return [];
        }

        $xmlObject = simplexml_load_string($xmlString);
        $xmlObject->registerXPathNamespace('loadBookingResponse', 'http://ws2.vip.server.xtrip.gridnine.com/');
        $messages   = $xmlObject->xpath("//messages");
        $bookingArr = $xmlObject->xpath("//bookingFile");
        $booking    = $bookingArr[0] ?? null;

        if (empty($booking)) {
            Log::alert('Empty booking xml string');
            Log::alert(print_r($messages[0], true));
            return [];
        }

        $bookingReservation = $booking->reservations->reservation;

        $bookingDto                    = [];
        $bookingDto['bookingNumber']   = (string)$booking->number;
        $bookingDto['createDate']      = (string)$booking->createDate;
        $bookingDto['status']          = (string)$booking->status;
        $bookingDto['recordLocator']   = (string)$bookingReservation->recordLocator;
        $bookingDto['timeLimit']       = (string)$bookingReservation->timeLimit;
        $bookingDto['airTicketsArray'] = [];

        foreach ($bookingReservation->products->airTicket as $airTicket) {
            $ticket                    = [];
            $ticket['passengersArray'] = $airTicket->passenger;
            $ticket['segmentsArray']   = $airTicket->segments;
            $ticket['priceArray']      = $airTicket->price;
            $ticket['taxDetailsArray'] = $airTicket->taxDetails;

            $bookingDto['airTicketsArray'][] = $ticket;
        }

        return $bookingDto;
    }

    public function parseBookingToken(string $flightXmlString): ?string
    {
        $xmlObject = simplexml_load_string($flightXmlString);
        $xmlObject->registerXPathNamespace('selectFlightResponse', 'http://ws2.vip.server.xtrip.gridnine.com/');
        $messages  = $xmlObject->xpath("//messages");
        $flightArr = $xmlObject->xpath("//flight");
        $flight    = $flightArr[0] ?? null;

        $bookingToken = $flight?->token;

        if (empty($bookingToken)) {
            Log::alert('Empty $bookingToken can not create Booking');
            Log::alert(print_r($messages[0], true));
        }

        return $bookingToken ? trim((string)$bookingToken) : null;
    }

    public function parseBookingNumber(string $bookingNumberXmlString): ?string
    {
        $xmlObject = simplexml_load_string($bookingNumberXmlString);
        $xmlObject->registerXPathNamespace('createBookingResponse', 'http://ws2.vip.server.xtrip.gridnine.com/');
        $messages   = $xmlObject->xpath("//messages");
        $bookingArr = $xmlObject->xpath("//bookingFile");
        $booking    = $bookingArr[0] ?? null;

        $bookingNumber = $booking?->number;

        if (empty($bookingNumber)) {
            Log::alert('Empty booking number no booking created');
            Log::alert(print_r($messages[0], true));
        }

        return $bookingNumber ? trim((string)$bookingNumber) : null;
    }

    public function getPrice(SimpleXMLElement $flight, PassengerTypeEnum $passengerType): int
    {
        $price        = 0;
        $flightPrices = $flight->price[0];

        foreach ($flightPrices as $flightPrice) {
            if ((string)$flightPrice->elementType === "COMMISSION") {
                continue;
            };
            if ((string)$flightPrice->passengerType === $passengerType->name) {
                $price += (int)$flightPrice->amount;
            };
        };

        return $price;
    }

    public function getFullFlightDates(SimpleXMLElement $flight): array
    {
        $transfersCount = $this->countTransfers($flight);

        if (empty($transfersCount)) {
            return [];
        }

        $transfers = $flight?->segments->segment;
        $arrival   = $transfers[$transfersCount];
        $departure = $transfers[0];

        return [

            'departure_date'      => $this->getDateFormatted($departure?->dateBegin),
            'departure_time'      => $this->getTimeFormatted($departure?->dateBegin),
            'departure_timestamp' => $this->getUnixTime($departure?->dateBegin),
            'arrival_date'        => $this->getDateFormatted($arrival?->dateEnd),
            'arrival_time'        => $this->getTimeFormatted($arrival?->dateEnd),
            'arrival_timestamp'   => $this->getUnixTime($arrival?->dateEnd),
        ];
    }

    public function countTransfers(SimpleXMLElement $flight): int
    {
        $transfersCount = $flight?->segments?->segment->count();

        if (empty($transfersCount)) {
            return 0;
        }

        return (int)$transfersCount - 1;
    }


    public function getFlightTransfers(SimpleXMLElement $flights): array
    {
        $outputArr = [];

        foreach ($flights?->segments?->segment ?? [] as $flight) {
            $flightInfo['aircraft']            = (string)$flight?->board?->name;
            $flightInfo['airline']             = [(string)$flight?->airline?->code => (string)$flight?->airline?->name];
            $flightInfo['arrival']             = [(string)$flight?->locationEnd?->code => (string)$flight?->locationEnd?->name];
            $flightInfo['arrival_city']        = [(string)$flight?->cityEnd?->code => (string)$flight?->cityEnd?->name];
            $flightInfo['arrival_country']     = [(string)$flight?->countryEnd?->code => (string)$flight?->countryEnd?->name];
            $flightInfo['arrival_date']        = $this->getDateFormatted($flight?->dateEnd);
            $flightInfo['arrival_time']        = $this->getTimeFormatted($flight?->dateEnd);
            $flightInfo['arrival_timestamp']   = $this->getUnixTime($flight?->dateEnd);
            $flightInfo['departure']           = [(string)$flight?->locationBegin?->code => (string)$flight?->locationBegin?->name];
            $flightInfo['departure_city']      = [(string)$flight?->cityBegin?->code => (string)$flight?->cityBegin?->name];
            $flightInfo['departure_country']   = [(string)$flight?->countryBegin?->code => (string)$flight?->countryBegin?->name];
            $flightInfo['departure_date']      = $this->getDateFormatted($flight?->dateBegin);
            $flightInfo['departure_time']      = $this->getTimeFormatted($flight?->dateBegin);
            $flightInfo['departure_timestamp'] = $this->getUnixTime($flight?->dateBegin);
            $flightInfo['flight_number']       = (string)$flight?->flightNumber;
            $flightInfo['duration']            = (string)$flight?->travelDuration;
            $flightInfo['seats_available']     = (string)$flight?->availableSeats;
            $flightInfo['service_class']       = (string)$flight?->serviceClass;

            $outputArr[] = $flightInfo;
        }

        return $outputArr;
    }

    public function getAirlines(SimpleXMLElement $flights): array
    {
        $outputArr = [];

        foreach ($flights?->segments?->segment ?? [] as $flight) {
            $airlineCode = (string)$flight?->airline?->code;
            $airlineName = (string)$flight?->airline?->name;
            $outputArr   = $outputArr + [$airlineCode => $airlineName];
        }

        return $outputArr;
    }

    public function getAirports(SimpleXMLElement $flight): array
    {
        $transfersCount = $this->countTransfers($flight);

        if (empty($transfersCount)) {
            return [];
        }

        $transfers = $flight?->segments->segment;
        $arrival   = $transfers[$transfersCount];
        $departure = $transfers[0];

        $departureCode = (string)$departure?->locationBegin?->code;
        $departureName = (string)$departure?->locationBegin?->name;

        $arrivalCode = (string)$arrival?->locationEnd?->code;
        $arrivalName = (string)$arrival?->locationEnd?->name;

        return [
            $departureCode => $departureName,
            $arrivalCode   => $arrivalName
        ];
    }

    public function getFullFlightDuration(SimpleXMLElement $flights): int
    {
        $duration = 0;

        for ($i = 0; $i <= $this->countTransfers($flights); $i++) {
            $flight     = $flights?->segments?->segment[$i];
            $flightNext = $flights?->segments?->segment[$i + 1] ?? null;

            $duration += (int)$flight?->travelDuration;

            if ($flightNext === null) {
                break;
            }

            $durationTransfer = Carbon::parse($flightNext?->dateBegin)
                                      ->diffInMinutes(Carbon::parse($flight?->dateEnd));

            $duration += $durationTransfer;
        }

        return $duration;
    }

    private function getDateFormatted(string $dateString): string
    {
        return Carbon::parse($dateString)->format('d.m.Y');
    }

    private function getTimeFormatted(string $dateString): string
    {
        return Carbon::parse($dateString)->format('h:i:s');
    }

    private function getUnixTime(string $dateString): string
    {
        return Carbon::parse($dateString)->unix();
    }
}