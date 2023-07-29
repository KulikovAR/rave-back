<?php

namespace App\Services;

use App\Enums\EnvironmentTypeEnum;
use App\Enums\PassengerTypeEnum;
use App\Interfaces\FetchFlightInterface;
use App\Models\Order;
use App\Traits\DateFormats;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Log;
use SoapClient;

class TripsFetcherService implements FetchFlightInterface
{
    use DateFormats;

    public function fetch(array $request): string
    {
        $airportFrom            = $request['airport_from'];
        $airportTo              = $request['airport_to'];
        $dateStart              = $request['date_start'];
        $timeBeginFlightMinutes = $request['time_begin'] ?? 0;
        $timeEndFlightMinutes   = $request['time_end'] ?? 1439;
        $adults                 = $request['adults'];
        $children               = $request['children'];
        $babies                 = $request['babies'];
        $serviceClass           = $request['service_class'];

        list($soapClient, $apiCredentials) = $this->initSoapClient();

        $soapClient->__soapCall(
            'searchFlights',
            [
                [
                    'context'    => $apiCredentials,
                    'parameters' => [
                        'eticketsOnly'         => true,
                        'route'                => [
                            'segment' => [
                                'date'          => $dateStart,
                                'locationBegin' => ['code' => $airportFrom],
                                'locationEnd'   => ['code' => $airportTo],
                                'timeBegin'     => $timeBeginFlightMinutes,
                                'timeEnd'       => $timeEndFlightMinutes,
                            ]
                        ],
                        'seats'                => [
                            'seatPreferences' => $this->bookSeats(compact('adults', 'children', 'babies'))
                        ],
                        'serviceClass'         => $serviceClass,
                        'skipConnected'        => false,
                        'excludeAncillaryFees' => true,
                        'lowestFarePerAirline' => true
                    ]
                ],
            ]
        );

        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            Log::info($soapClient->__getLastRequest());
            Log::info($soapClient->__getLastResponse());
        }

        return $soapClient->__getLastResponse();
    }

    public function initSoapClient(string $locale = null): array
    {
        $url = config('services.port-bilet.url');

        $soapClient = new SoapClient($url, ['soap_version' => SOAP_1_1, "trace" => 1]);

        $apiCredentials = [
            'loginName'      => config('services.port-bilet.login'),
            'password'       => config('services.port-bilet.password'),
            'salesPointCode' => config('services.port-bilet.point_code'),
            'locale'         => $locale ?? App::currentLocale()
        ];

        return [$soapClient, $apiCredentials];
    }

    public function bookSeats(array $passengers): array
    {
        $seats = [];
        foreach ($passengers as $passengerType => $passengerCount) {
            if (empty($passengerCount)) {
                continue;
            }

            $passengerEnum = PassengerTypeEnum::tryFrom($passengerType)?->name;

            $seats[] = [
                'count'         => $passengerCount,
                'passengerType' => $passengerEnum
            ];
        }
        return $seats;
    }

    public function requestBooking(array $flight, array $passengers)
    {
        list($soapClient, $apiCredentials) = $this->initSoapClient();

        $soapClient->__soapCall(
            'selectFlight',
            [
                [
                    'context'    => $apiCredentials,
                    'parameters' => [
                        'flightToken' => base64_decode($flight['token'] ?? ''),
                        'seats'       => [
                            'seatPreferences' => $this->bookSeats($passengers)
                        ],
                        //'serviceClass' => 'ECONOMY',
                    ]
                ],
            ]
        );

        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            Log::info($soapClient->__getLastRequest());
            Log::info($soapClient->__getLastResponse());
        }

        return $soapClient->__getLastResponse();
    }

    public function makeBooking(string $tokenBooking, Order $order)
    {
        list($soapClient, $apiCredentials) = $this->initSoapClient();

        $soapClient->__soapCall(
            'createBooking',
            [
                [
                    'context'    => $apiCredentials,
                    'parameters' => [
                        'flightToken' => base64_decode($tokenBooking),
                        'customer'    => [
                            'name'           => $order->user()?->userProfile?->lastname ?? 'airsurfer',
                            'email'          => $order->email,
                            'phone'          => trim(trim($order->phone_prefix) . trim($order->phone), '+'),
                            'countryCode'    => "",
                            'areaCode'       => "",
                            'internalNumber' => trim(trim($order->phone_prefix) . trim($order->phone), '+')
                        ],
                        'passengers'  => $this->getPassengerDocs($order->orderPassenger, $order),
                    ]
                ],
            ]
        );

        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            Log::info($soapClient->__getLastRequest());
            Log::info($soapClient->__getLastResponse());
        }

        return $soapClient->__getLastResponse();
    }

    public function getStatusBooking(?string $bookingNumber): ?string
    {
        if ($bookingNumber === null) {
            return null;
        }

        list($soapClient, $apiCredentials) = $this->initSoapClient('en');

        $soapClient->__soapCall(
            'loadBooking',
            [
                [
                    'context' => $apiCredentials,

                    'parameters' => [
                        'bookingNumber' => $bookingNumber,
                    ]
                ],
            ]
        );

        if (App::environment(EnvironmentTypeEnum::notProductEnv())) {
            Log::info($soapClient->__getLastRequest());
            Log::info($soapClient->__getLastResponse());
        }

        return $soapClient->__getLastResponse();
    }

    public function getPassengersTypes(Collection $passengers): array
    {
        $passengers      = $passengers->toArray();
        $passengersTypes = array_map(function ($passenger) {
            return $passenger['type'];
        }, $passengers ?? []);

        if (empty($passengers)) {
            Log::alert('No passengers in order');
            return ['adults' => 1];
        }

        return array_count_values($passengersTypes);
    }

    private function getPassengerDocs(Collection $passengers, Order $order): array
    {
        $passengers     = $passengers->toArray();
        $passengersDocs = [];
        foreach ($passengers as $passengerArr) {
            $passenger = [
                'passport'    => [
                    'firstName'   => $passengerArr['firstname'],
                    'lastName'    => $passengerArr['lastname'],
                    //'middleName'  => $passengerArr['patronymic'],
                    'email'       => $order->email,
                    'citizenship' => ['code' => Str::lower($passengerArr['country'])],
                    'expired'     => $this->formatWithTimezone($passengerArr['document_expires']),
                    'issued'      => $passengerArr['document_issue'] ?? $this->formatWithTimezone(now()->subYear()),
                    'number'      => $passengerArr['document_number'],
                    'type'        => 'FOREIGN',
                    'birthday'    => $this->formatWithTimezone($passengerArr['birthday']),
                    'gender'      => strtoupper($passengerArr['gender']),
                ],
                'email'       => $order->email,
                'phoneNumber' => trim(trim($order->phone_prefix) . trim($order->phone), '+'),
                'phoneType'   => 'MOBILE',
                'countryCode' => "",
                'type'        => PassengerTypeEnum::tryFrom($passengerArr['type'])->name
            ];

            if ($passengerArr['type'] === PassengerTypeEnum::INFANT->value) {
                unset($passenger['email']);
                unset($passenger['phoneNumber']);
                unset($passenger['phoneType']);
                unset($passenger['countryCode']);
            }

            $passengersDocs[] = $passenger;
        }
        return $passengersDocs;
    }
}