<?php

namespace App\Services;

use App\Enums\PassengerTypeEnum;
use App\Interfaces\XmlParserInterface;
use SimpleXMLElement;

class CalculateFlightService
{
    public function __construct(
        public XmlParserInterface $xmlParserService = new XmlParserService()
    ) {}

    public function calculate(array $passengers, string $flightToXmlString, string $flightBackXmlString = null): array
    {
        $flightsToData   = $this->xmlParserService
            ->parse($flightToXmlString)['flights'] ?? [];
        $flightsBackData = $this->xmlParserService
            ->parse($flightBackXmlString)['flights'] ?? [];


        $flightsTo   = $this->calculateTrip($flightsToData, $passengers, 'to');
        $flightsBack = $this->calculateTrip($flightsBackData, $passengers, 'back');

        return $this->calculateTotalPrices($flightsTo, $flightsBack);
    }

    private function calculateTrip(array $flightsData, array $passengers, string $prefix = 'to'): array
    {
        $trips = [];

        foreach ($flightsData[0] ?? [] as $trip) {


            $tripArr                   = $this->xmlParserService->getFullFlightDates($trip);
            $tripArr['flight']         = $this->xmlParserService->getFlightTransfers($trip);
            $tripArr['token']          = trim((string)$trip->token);
            $tripArr['airlines']       = $this->xmlParserService->getAirlines($trip);
            $tripArr['airports']       = $this->xmlParserService->getAirports($trip);
            $tripArr['total_duration'] = $this->xmlParserService->getFullFlightDuration($trip);
            $tripArr['stops']          = $this->xmlParserService->countTransfers($trip);
            $tripArr['is_charter']     = current($trip->charter) === 'true';
            $tripArr['is_direct']      = $this->xmlParserService->countTransfers($trip) === 0;
            $tripArr['price']          = [
                'value'    => $this->calculatePrices($trip, $passengers),
                'currency' => 'rub',
                'symbol'   => '₽',
            ];

            $trips[] = [
                $prefix => $tripArr
            ];
        }

        return $trips;
    }

    private function calculatePrices(SimpleXMLElement $flight, array $passengers): int
    {
        $priceTotal = 0;

        foreach ($passengers as $passengerType => $passengerCount) {

            if (!in_array($passengerType, PassengerTypeEnum::allValues())) {
                continue;
            };

            $passengerTypeEnum = PassengerTypeEnum::tryFrom($passengerType);
            $price             = $this->xmlParserService->getPrice($flight, $passengerTypeEnum);
            $priceTotal        += $price * $passengerCount;
        }

        return $priceTotal;
    }

    private function calculateTotalPrices($flightsTo, $flightsBack): array
    {
        $flightsOut = [];

        foreach ($flightsTo as $i => $flightTo) {

            $totalPrice = $flightTo['to']['price']['value'] + ($flightsBack[$i]['back']['price']['value'] ?? 0);

            $flightsOut[]
                = array_merge($flightTo, $flightsBack[$i] ?? [])
                + ['price' => $totalPrice];
        }

        return $flightsOut;
    }
}