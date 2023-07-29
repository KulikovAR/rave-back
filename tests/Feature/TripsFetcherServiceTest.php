<?php

namespace Tests\Feature;

use App\Enums\PassengerTypeEnum;
use App\Interfaces\FetchFlightInterface;
use App\Services\CalculateFlightService;
use App\Services\TripsFetcherService;
use App\Services\XmlParserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mockery;
use SoapClient;
use Tests\TestCase;

class TripsFetcherServiceTest extends TestCase
{
    /**
     * @param array $passengers
     * @return array
     */
    public static function getFlightsArr(array $passengers): array
    {
        $xmlFile = file_get_contents(base_path() . '/tests/src/portBiletResponse.xml');

        return (new CalculateFlightService(new XmlParserService()))
            ->calculate($passengers, $xmlFile, $xmlFile);
    }

    public function test_search_flights()
    {
        $requestData = [
            'airport_from'  => 'MOW',
            'airport_to'    => 'BCN',
            "date_start"    => '25.10.2023',
            "date_back"     => null,
            "time_begin"    => null,
            "time_end"      => 1439,
            'adults'        => 1,
            'children'      => 0,
            'babies'        => 0,
            'service_class' => 'ECONOMY'
        ];

        $xmlFile = file_get_contents('./tests/src/portBiletResponse.xml');

        $mock = Mockery::mock(TripsFetcherService::class);
        $mock->shouldReceive(['fetch' => $xmlFile])->once();
        $this->instance(FetchFlightInterface::class, $mock);


        $response = $this->json('get', route('search-flight'), $requestData);
        $response->assertStatus(200);
    }

    public function test_tickets_calculation()
    {
        $passengers = [PassengerTypeEnum::ADULT->value => 1];

        $flightsArr = self::getFlightsArr($passengers);

        $this->assertCount(7, $flightsArr);

        $flightArr = [
            "aircraft"            => "АЭРОБУС А319",
            "airline"             => [
                "JU" => "Air Serbia"
            ],
            "arrival"             => [
                "BEG" => "Никола Тесла"
            ],
            "arrival_city"        => [
                "BEG" => "Белград"
            ],
            "arrival_country"     => [
                "RS" => "Сербия"
            ],
            "arrival_date"        => "30.06.2023",
            "arrival_time"        => "01:05:00",
            "arrival_timestamp"   => "1688130300",
            "departure"           => [
                "SVO" => "Аэропорт Шереметьево"
            ],
            "departure_city"      => [
                "MOW" => "Москва"
            ],
            "departure_country"   => [
                "RU" => "Россия"
            ],
            "departure_date"      => "30.06.2023",
            "departure_time"      => "11:00:00",
            "departure_timestamp" => "1688122800",
            "flight_number"       => "651",
            "duration"            => "185",
            "seats_available"     => "1",
            "service_class"       => "ECONOMY"
        ];

        $this->assertSame($flightArr, $flightsArr[0]['to']['flight'][0]);
    }

    public function test_request_portbilet(): void
    {
        $this->markTestSkipped();

        list($soapClient, $apiCredentials) = (new TripsFetcherService())->initSoapClient();

        $response = $soapClient->__soapCall(
            'searchFlights',
            [
                [
                    'context'    => $apiCredentials,
                    'parameters' => [
                        'eticketsOnly'         => true,
                        'route'                => [
                            'segment' => [
                                'date'          => Carbon::now()->addDays(7)->toISOString(),
                                'locationBegin' => ['code' => 'MOW'],
                                'locationEnd'   => ['code' => 'BCN'],
                                'timeBegin'     => 0,
                                'timeEnd'       => 1439,
                            ]
                        ],
                        'seats'                => [
                            'seatPreferences' => [
                                'count'         => 1,
                                'passengerType' => 'ADULT'
                            ]

                        ],
                        'serviceClass'         => 'ECONOMY',
                        'skipConnected'        => false,
                        'excludeAncillaryFees' => true,
                        'lowestFarePerAirline' => true
                    ]
                ],
            ]
        );
        $response = $soapClient->__getLastResponse();

        file_put_contents('portBiletSearchResponse.xml', $response);
        file_put_contents('portBiletSearchRequest.xml', $soapClient->__getLastRequest());

        dd($response);
    }

    public function test_select_booking_portbilet(): void
    {
        $this->markTestSkipped();

        list($soapClient, $apiCredentials) = (new TripsFetcherService())->initSoapClient();

        $flightToken = "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";
        $flight      = ['token' => $flightToken];

        $passengers = ['adults' => 1, 'children' => 1, 'babies' => 1];

        $response = (new TripsFetcherService())->requestBooking($flight, $passengers);

        $soapClient->__soapCall(
            'selectFlight',
            [
                [
                    'context'    => $apiCredentials,
                    'parameters' => [
                        'flightToken'  => base64_decode($flightToken),
                        'seats'        => [
                            'seatPreferences' => [
                                'count'         => 1,
                                'passengerType' => 'ADULT'
                            ]

                        ],
                        'serviceClass' => 'ECONOMY',
                    ]
                ],
            ]
        );

        file_put_contents('portBiletResponse.xml', $response);
        dd($response);
    }

    public function test_create_booking_portbilet(): void
    {
        $this->markTestSkipped();

        list($soapClient, $apiCredentials) = (new TripsFetcherService())->initSoapClient();

        $flightToken = "H4sIAAAAAAAAAO09a29cx3Xf+yu2Bgq4AYac90OgiVIUpaqQJYKUXBhBYMyT3nq5y+wuZStFgUgpGhRN67hIgT6QOE6+FChS2EncOHas/IXLf9Qzd59c7uMuRUqkSQkgdu/OnDtz5rzPmZm1lvub6Ls137Cdzhuv+db+yl67Hpr1Zlz5oNuuH6zAo/1Wc2UvdFb2WyE2Vm436nvvdl9b/5Ma/Fs7rId17KQVglJkieOIp6SRDYqggJVIgVhiBV5bzS17fQDW+u7GzZ2ttdX8sffQH3a6rf3tdusgtrv12H9c/lTvxv3FI+yNrvOkA61X7tv9GN6yjcP42gjQcMA+Yp6IIEjRxBBXUiIthEchGikSVsk7PzbgYd8mQF3vxE6n3mo+qoe11fLB8TaP80vX1/7025u3Nh5ufJsSHg0nDFGnA+LWO6STt0ikZLDxgCbD/+Jx/QBhTtFBuxXQfkgeNWML0dFEYYrf+c762moP+Agzqxk154kpZ0MwHlbVuYAR94EhZ01CQSscjDAOKzkTU7C4N1JJLci3mt3Y7FbBWIwuRk8IwobkxeEBaRcFclh6zSwRMpJXgwyWiIsYVpAGahDnFNaSWY6oiUwmYo2mZi4yOrEBzIb6OOm2rY9VMOICVTZEhqwBmuXEGXhvokhYiZnBNlEuXw1GktfYSE0RB7wgLoNF1ieLVPTeKee85WImRt7voE7rsF0NBz3ULZrl2up0MbLWrfv3YnezddjsrpO11fGvvQb1Zr17y3bjOsWUIawQ5TUibzB+g4gVqWFdhy16HVzDNt978H4ztqtidKvZrXef7MQU27Hpx/FZ4jI4kBOOC6B7EwGXWiMTpUKRAAtSCovM2QQu17pPDuL6oveCVEn1Rlx50N6zzfr3bBekF6Agdx1B8vYgPx8h/ObudontwQ99/I6mPZDbtt2uZyT02r3x2ka9XduNbVe3r1XFTKj77gr0a8DvY/j5q0f59SX4/ssaMPjmTtyrd4B5ymF124dAPyef99rH3kL3Ww2+DUhiP96r79e7vSUnGPi4RukNgW9gvIIxzmQyaNLrYr3PJLMJg944OGjUY+hDnvLDgEpa/r3Nd227C3NIttGJGYVjz3rNOoeuUw/178Xw0LbrKQ2annjeJ9a9ZqsdN0Gmggjpdm632rsTDW837N4ASMXWQ928edjOC/Akz2Z969FOqaWPPRw23ejN+4w4QPLAhPQBYQYaknOJkQtZV2JiaODYWqKW5IBstnSsa8f+CHbz5zvDgS9mg7JD7fVbW38+jRtGKBgQFbwbFhYk0gDft2LX1hudqihyrdZ79ebeysNZgCaRhnXw1GEQwZ6ChlYmIBcNRSZJKT3xPtJJDb3WbHUzmT45+ZLOgGjmNRlTKJ3OYQyPmiG2WRjS27GHY6PtxO3Y7rSat+qdHrvY9rDT9B/7aJ6J1X6DZgRKbpXj3T50jbq/bdtxAGg4o7mN+nxoG7EDrFlvLrteu8OekwsE9i9RRnBkRYRVkqC4teIRGeMUCzpIL09QdYgdD6/KpPbivDUcSTk75PMg0e6jmxt3tu4/nKadl9Iqo4nfGg16kq+m81bxydEPis+KT4vfFJ8XXx89O3pafFl8evRhrfjj0feL58Vv4af/Kz49yXg9qhhD0jgH9ymk1e5MvH8Z62ewrJtDaBMIHSKVehqVVmD9OKyz80PAXLUOWRoF08GYlCbV9vkt87GRjTABq729fe/u1s6MgSy/6iO8LFj12av/ty/0rhu1R3dvvfEYRAZ8QRhNmezfTSecBQQ0hZDOY22wT2B1YMQUBldCYyCYSCTCmClKQgwqTnMlTrdY8wy/+WtUfFR8UnxM3yk+Ln5Z/NcifI4wNsF5E35I+ex8uJFbAnYD8cjzKMErEQHwSjliDpwlbhOTnL9ybsyCd/PtK8GLvaleZE6MGMQ0sRFRK4BiKAfnOvv4ykolCbMYh3gROPFfiy9ALT4tPgfV+Ovii6Onl4AbQS06KTDglgAj8iDBLKUYPFwGLq3mIjJLXzk39i2hK8KQw9leZJ7kVDtmwJJSChQj55yBFHcKCeXAlnbUJBouAk/+e/FxrfhfYMgviq9rxU+KPwBfPiu//r4GDPsV2K+/hS/5cbZnM9v+8BKwbQJPhSeqUVBSIc6IQEYEkxk4pGQDpSG9crbdBBNvqvtyOiq4yDzbm+pFZtjok3eYURQ944hbrJCRnqFkKPzHlCQ9i2KWX6oXYNifAxf+rvg68yE4nP+U2fRLYNMvev7nWbHmeMtBiGJ1FFoYBBObvt5o2PaT2zF2duJ3D2Onez9GsP0HEYs5LXogeomEHMfo7Ebb9u/eqnesa4wgzG7QH0MI9Txb27jfat5s2ybALltvPLb1Rm45HMvilv0QSrTdzpv24ASEkz/0OrTGlrMfA77Zah52cgCos23bdj92gSuWSVE+qAZyMlJjkiXBUoFi9DlXx4GKWbBIikBZIJgbOZnNWLONRuv9u82Dw2GcaexJf+krznAQQmwdth8cxLYF6skYHsA98bzX/KBdf2y7cfSkfBqB/p5MUOl78ckoSg/q6XdZKYFF+VVmhMqx+oEa2YbWsbkX2w+BAceExMatR/dALMPLpiZ0+pM5kcMZG/Da6ok5AVXt7UOTXrh6+dzwZPZ6dxzctFCZddJRbHMYNSchBabIOk+RiuBDcoeVC9P8yME4O1PExwuNdJ7wJc6Bio4MScYw4k57GDWo65QSByNbUkfmCt9p6fgTjWan50850WpZxqkTdl57K0lCwkWLeOIeOZkESgrrYJITPs5yK47BKrOOb+YEk92Ld9oH0/KQJzpN5CXxtJTkiU5TbLfRb9VQu2Z7kuO8Em198DNe3lMk9w/3XWyvS2EGqqX/ZHqnVimtQFhsnO/QJ98zYziNli9F8M24l+P7Q0n446N/Ls3zP4I0/P7Rs1rx36WT/TnY7Z+DOf8j+PTr4vlyA70TW/f6rxsbLOD4oNXu1nbferC2emw4C4a81QxjA/4pGCxfwoDBv6gVv4BBPs0fz3KAN7fujAYIL58xvABCujf8QQqV4Ro+lkIdNZkNIr9gHACH3scAzB6Ba4EOHV/L4ldg5P2s+Kj4ZfFJrfgxI2ZpCvNtm7pjSAEYa6vli2ZZr237ODZuHfZTz8Tk1PHxZ9M7At8fdNahde/DrEY59dXc66eah19ntD4sC7oetu60wJdoZt2xcQCWM0iosaTyzCazsFzq/M2Mx/WbGRlj32d0qZT4njbZ7mFn/dH9zQf3b9/deXPrVjnj/Gym8robcklH78MMqLH9uO5jb7xbAPrBm29ng3Ts6QyxBxbI3WZqvbi6G9PrfZhVNJ3klEVPDcpBD8SxjmCGcLBKuLaBiCSZ0FU03cG4sfbyjMBjr10wxIzqm7ZTBwK7f/PBDoj10ZP5Pdtx37bf6zs42beOH3RHCnptmQrHXqnAu7EBGqXTKxbYmQJ9UPwI1l5fAZJMTnvj2nDtoJz0xq2Mh978QVOVY1kvbYapw54/08bh3h6YKpl6ll0pkOwr90bdFxBf+bYyEsejTsarHMGViHOTkAMPFAmBnfc+KXIieT0TXrM+FEH5Y4UBNOuVS0tK4d2f4CPoN0aM9+/euw9jbNYXoXd1DL8VqLVyZcdx3j9ZxzEbAdkTiQFHKRzCnilwSoVHmmDQlU56YZgVFM/KL5+A562rN+8tT0R5AlsfdGN2+pcjouE0dNDEUlmSD0zDEYK0UA4Z4XGI2GJOXMVplDAP6tGDqQx81/9Urdv7MVut6yA0+5+qdevUvxfXCYFu5afFmF6dRHWFPuD1emDV04U8MmVtTwJYZoHAoXJOYI+SZTn4YTBygoPmiTRSpZP10S6zQCEme9jo9sc0YPyJp9VAuRxuAuX+9j2wIfqfKyzBCXwuYv8xpl6kT2PTNrKvtiwXbY93rCoChFRchcDAwQULmUtFkZYCrABPBScsGMKrCGHAyPjbT+uuzrGJZnU8v9iHxlhozx1K1IJ+0owip5lFNoGBRA2YSGqegXT5Yh+GRsakDAhrHxFnEiOjQaIyEbSUyWJH8XXs4/xiH0Lzb1Ls4yWHEpaPdfwKPJMfoeJjcFM+PXp2pgPbvH/qGAdRN7B4kRgHMTe4uMwxDnk+MY5BiOI6yDHeoRfboN/QIIdIBhSaNAhLRsA1cOAkcO0ROAUuBB0xqPbrIMcFCHLQb2iQQ+Zdnw68Hi9NyPsowC31WKNggvLMqKRCZRf7OshxmiBHBO+TRc5znBNWIAYFHg4RSEbNvfIkgVS4BEEO4X3wJOa6NcMRpywhrQQHR9rpxKhKxs+qPp4K8zrIccZBDnCjjVPcIMF8rlMKAbkkPGIBM8pF5NO3M8+EeR3kOLMgh7aEMmo1SlKFvJXYIaekR8R4QXje/sfn7YgYw8grCHKUinGi8OP4vuRpBSylgH3xYpbMFdNqWEKMOPBIc7AeIy40Rk7qgII1YGhpxwSdFja6gHbUWvzuYR0s92zE75fb9QRTK9lzOvHD8X7OdmLvhyWDMm+2mvHJzC1fyjvDczReEAt/ctApJIYYNRETmQJns8qT+yGUwfBnxE7WfH+3bW/77fDbBM2NZjeL6sYIbK1rPzgDYntoP5hGa8ZI7gkXCNR4jh47AyghIcf4U8JJM2+mRY8vIq35vMN5524u4gwL6ZDIlXzCwWwyPOUZDBXRLgLj3EqLaAj5/AWnkWVRouAsDUkZ6uylQvu9O9XQzle4foVYBzOhjMd7Uu67Jh5Z52QuQgvCOUOEIZcJ6zu7VbHO6KvDekqKRgaeAXYpIh4A4RprgzjxwYFA9dhO89IuLNbf3qkoYugCTXe+aJfOc02YQyFqh8CA1iDZpQG7jJoALg7jYlp16YVF+87tamjHK6ayiFlbHVOuvZLwGLbtk9Lig3FMqt31u/ffenB3c2vqyq0/3Np58+79jXvvPHzwaGd74+0FraDFw52Nt7buHR/RzFEMd4LsxEYZuB0f3UWtGx+85W/sY7ty2K03VjbabfvkXr0zLT24NAfcCZ3NCazcsl07L/OIRQpGiIgcEQlxTQly3hEkHJVBGR9ImrtH7dw2Sg1H2O7PZLghHgjqnYVbHcvup9o6NcRctQ1U5YtObtH5SfG8+E25We750fdrR09rZV3u06NnxafFr4/+sZ+v+sP8vTol7Pkbosome7EZ27aR1/q02+gGs74zArVoYbAGS80mkKEuCSCdpJG2DOw3Ez34FpoxP69gv4+4hj8cUuq0Y6vkCssHRk02nAOy72YsFY0cnAuUneUxytx5dHOW33LsnW0YUtX3Deht6wP/rgUJsgN9F6B7iHKPwV8j4JBQlgOM2ILJluupdCAxeKyZwJWiC68AR0M8/XW9++5mK6ZU9/WYDQNCVnK0btpvC6CBKgtAxG9mPfhoG0CMP6jWt6xYWH/rHTLq/db8SoDhRErVfBe4vTf2CnkTPz7tlbxUvvJkBxgekMuy5LY50b9yTBtr4bgSCOvsEnuwXG004KolR3UyGLyEaYdMLpzDSBeD97GCl1bA4/MZT4sfdlsgPUClMTUiy525ImM4vhyJGMDt0fWxJ9UnOC/gMbVjOCb8aC3vHOA3KF6Rop9YrwAkU+F6ic0eRVbo0h3R8HwVV7ZenSTCBe3rwE/tCMol74KrtzvDzYUnf6gOaBqMefHR+ZgYmpFV6e9+7HRjqG7DlC8pj92k2lCGHUomu3v5QFDr86k5DidjlHB66iGTJ2CdyqiptLwvvhV8s6yDiu2sIno7wZX0BifMURAuRxphwjriiBLDwhNOQXroBVvCj42xOYb+R4CrKvDzoWnHe1V/x8PTYHscDcdfPl9JjHZcVyDYs7D2NsdgVdqyKI1zURnEypCRJRFZKwzCxGNCovKeV1EGSzPdcuw2HO4ZsVwJ79zYroeQSdbbPmzUtj44aMdOp3Zn3/1l7VvHD7H6Vq1W/Laaj5HP8CiP+PiiVvxb8Z/FL2rFT4ufwcP/Kf6jVnxWnu/xdfFlbepRqTNHXIVUV8dpdZ6f1rbNDlBk3D0sjx1t55MC+hvFpv82w1Uac4RmNOkXEp0F8+yOQC1ylVwy4ExzgjxPOB99HJBmYEQpgoESrUtWLrLb17qtrm3kZGxcl8wIlbX82LPZHQ96sZOJrseezu4cIryhv+n/DBF2awxsFcGDUyROMokiNwRx7jH4PN6C4DHeRKcTJvPCFENYOZO0LozCPOMgHTttYDrWj6ebZrY7zRE2u/X9g0Y8GbCciwmmmReSKNBw2QXMpzVqFyViOAUqPXw2VWVaCXNOnmhmH9sP6WpqMhrtlJzl1H5zctXH2r00ZHrwbKhy4M3InFvO+5OMSh5p0GMMB6UJXh6Z07M/M/v0scfNZcdldrmU5Qhzno9bMjnCzgQKwfFglPbaVtnkOYQ5J6czs88Al5pcclxabznXEQUDGOQp5fMfjUAqJK5dEDikeaf5nYA5J1Mzs8+AyRkTlxuZVHEfQcsCHmmCPx4kJgcXwXNilI+KRFMlaDaEOSf/MrPPAJn4zJn8WNJmeoNxHT7Lchqzi2Y0yQtSL+8MOcsK6zJlMQBcaS+5IF5Yw/NWKZVZwyPjgkcq2ShcFEaGSiHQMiyAq4VKpqXVFlbtzEHgaKPQOTtA3BlhCQgOqYRHIIYtcppoJIzQ1AUplwjeVXKABow6muvK5pRpn94vAv/leXkS4dOjp/D3w9qfLeeznBxLRVe19Nzf2rp/68HOyK9Z5M7P3TM2j5/ObAviKVKCnFHlBYtIawpOfqAeOaEZePqKOWKtDXM3MrzMlGAvDZgTglWOPy37X6ScIBDxsZPjL3tG0CmiWaQMKW2BcpzKtwVogjATxCTqlU2LCscrZgT5dUZwcGmZll45jLDkNh9ZycC4kRYpEO2KRh1tNcd4WvZtqB2XS8v5SRDVk1xnkTC4OBF/Xl4clxNmzoCpYqhFOvuZYI0SyRgPPnwDI/4iJcG9iCjSAOa2EQFmDfMXAqSDtPBXiheJ+FeBfx3xP6uIv/KEBkklSpwADeNcHyQEzRF1mmulPXVVPNGXFfE/I5Yr4b3kiH/xcfHz4hfFRyhrvFXwFKWqncPR3McGcR3EXyKIb2WM2ui8VSJfFeiCAM9TunydoWUuYSL5IlV7tYP4CiQ3JQrMOYpjvtUEvFEsFPI2OiIEuKOu0gEwlz+IL7kyXuT7SJPOV2ESjgwVCRFOktCKKhqWOqXoSgfxWSDJuJD3jCSNOLUEaQMeg2WUKiOYSidunJwL8yoH8amSPm/+Av/BYNCfjgAavUFG8CQ1liSw6yB+hTmUdJkLUEBQo8hVVhpghlhCOSKCKsyY4xRXOeNoCPNKB/GDCD4FlhAzSebTNSQymAQUMFdUG09cXGpP+nUQ/1UG8XHiOPIgkSfGg/6LwBoGUxSo4RJWmie8qHS8hGXPclPs1JFKnyurQTVLx0w+CwEjx8HlFAlbwfNWOVKVifubZsuQyILTxoZd/LFq1IpV1pVI89LmNFRiWFmWb1JPYDsJq5DhuRDeeM9oNqBc1cMPLmpO4+budu3o73P91qL70Y4BfuH0xlgQ/cUzHOXv5y5JkhNG5oKDqDDoBVCsyHIVEJjX0RAluKx26tL5SxLBCHGYRiRs9iEZp2D9EwtfQ8ICW+9NVQ3WlyREXFhZ0h/aJZAmWYh7DdYECQ6kSTDIGfiEgyLW6yS9qXIJRwnvtNLkdoxnIkb6AaRa8UnxWZliKn6Xz0Mcu4X46Ae113sPPwPp8lW+GGLKheAzX3kVBYzg2loPBrzHXICAYREUDwgYHL0j2CciqgXxy6SE+KYXHATCifOMIa0l+OJS5o2lNCFsvMPBW5ALlU/AuqDs9BwY6lkv5pofHP0DqOx/qeWi6xyXBbU946bvqW+9ihxFVLQhAh9RnkARKpqP6FYcBe0DjtgbWSnG8BJUtmfSJ28iYiwf6SiChZFGilJI1kUlaKjkppTwelpankphL7Gb7LQKWy48n2H6EF++iGEy2ZCPOXSecMQNLIo1LiHDRGLR+WTkpdHYnxQfFT8rfl4DD+Dj4le11/PFyMVv8o1NuRzk8qrmC1zdZHJtk/cJUSLzXTTSIuMEBoMceNqEbIvPvWbupR54cHNU4LTwotiy/0Wqbhq/k/TSVzZhxaTLCRvtwM2UTCAjBclRIWYoCCI29SLFCZRVqWwyV6KyqQaoeuO1KsVLr61ehFKeaLgzxhOUtM6FtIEg7WUudDOUK+8jI5XuarxcpTycUxd8YiAhmUQkHwlrjRaIeJmksM5LTl6klKcK/OtSnrMq5eFMJ52vXhGCO6DhKJA2hCAvY0zUOM15paD7SyrlOSOWK+G97FKehbqw3KpbO/oBmHrPi6+Oflhuwc1+JKrBh89rpW/ZMwM/LH4PfeBRtgyfXxf3nE9xTxLOeJ4CAqoSiAOBIUNNvpqGah8lw4wvClxc7eIeBsoaMyqRBmcevHqZP/l8SICjQghHNZ52muQJWJe/uEdZGij2FgkeWa5BNDkboRENIpAo4ZfKNYglzKtd3CMks5bks2BVvrmRU2TzQUSWUCwVFZLTKvXtQ5hXubiHaxlI3t7sY8rHxvsA7kx0+RQCF0VMOJKljo2/ysU9liedwH1Blltgcu4o0rmgkRJFMXeO+FhF3A1hXuniHmU4Vfm8fGMyYSqdr86JGmmsRMiZOFX5nJYS5nVxz6uM7wfHcEwyb8lNubgnUWSUNyglSqVgKWBdacvAC8T3e+GFKhn3eeGFchTXqe3aBQiUX/zU9iA+Wy14XvbvtA7bvkIsbRYv9qi8SgXM3CDaK08IYpaM8IGBmMg1dsaAXRI8RsyAXvCacV4txf7CAqNKvm95gXGdWrviqbVXJhqqZNovtmgQzqSk83lC+QYgbojuRYidZYZG7ay3le4JvhKnfSSXTIwELC2crwVTefu9kQblC8GC4T46UXVX0UWpjP2krIp9Bkz7h+Lr4tOjD2u9Mw1HxbKvn4iXHj07+tEF5u8zzpufKCcBSh3dfjAa1MQ1CcevRbtMdycsekuVq9t6OV1mlGYgGDHOd5ATmXeQZUfB2sTBbhI6Tb0SZAHCpyF2rRNt90VurdqF/tvtAaomLwvsK2/LUzb8smeDuLMCaRU9IoR4ysHVMX6aqLyYN5yUjlYm3jmXlfRxOryp9f8BuZ8L/QWwAAA=";

        $response = $soapClient->__soapCall(
            'createBooking',
            [
                [
                    'context' => $apiCredentials,

                    'parameters' => [
                        'flightToken' => base64_decode($flightToken),
                        'customer'    => [
                            'name'           => 'airsurfer',
                            'email'          => 'www@www.ru',
                            'phone'          => '79253002211',
                            'countryCode'    => "",
                            'areaCode'       => "",
                            'internalNumber' => ""

                        ],
                        'passengers'  => [
                            [
                                'passport'    => [
                                    'firstName'   => 'www',
                                    'lastName'    => 'wwww',
                                    //'middleName'  => 'Alexander',
                                    'citizenship' => [
                                        'code' => 'ru'
                                    ],
                                    'expired'     => '2025-10-21T15:23:38.346Z',
                                    'issued'      => '2015-10-21T15:23:38.346Z',
                                    'number'      => '432112345',
                                    'type'        => 'FOREIGN',
                                    'birthday'    => '1986-10-22T14:24:06.953Z',
                                    'gender'      => 'MALE',
                                ],
                                'email'       => 'www@www.ru',
                                'type'        => 'ADULT',
                                'countryCode' => '',
                                'phoneNumber' => '79253002211',
                                'phoneType'   => 'WORK_PHONE',
                            ],
                            [
                                'passport'    => [
                                    'firstName'   => 'children',
                                    'lastName'    => 'children',
                                    'middleName'  => 'children',
                                    'citizenship' => [
                                        'code' => 'ru'
                                    ],
                                    'expired'     => '2025-10-21T15:23:38.346Z',
                                    'issued'      => '2015-10-23T15:23:38.346Z',
                                    'number'      => '905432211',
                                    'type'        => 'FOREIGN',
                                    'birthday'    => '2015-10-22T14:24:06.953Z',
                                    'gender'      => 'MALE',
                                ],
                                'type'        => 'CHILD',
                                'email'       => 'rrerere@mail.ru',
                                'phoneType'   => 'WORK_PHONE',
                                'phoneNumber' => 878787878,
                                'countryCode' => 'ru',

                            ],
                            [
                                'passport' => [
                                    'firstName'   => 'babies',
                                    'lastName'    => 'babies',
                                    'middleName'  => 'babies',
                                    'citizenship' => [
                                        'code' => 'ru'
                                    ],
                                    'expired'     => '2025-11-21T15:23:38.346Z',
                                    'issued'      => '2023-06-22T15:23:38.346Z',
                                    'number'      => '905432211',
                                    'type'        => 'FOREIGN',
                                    'birthday'    => '2023-06-22T14:24:06.953Z',
                                    'gender'      => 'MALE',
                                ],
                                'type'     => 'INFANT'
                            ]
                        ],
                    ]
                ],
            ]
        );

        $request = $soapClient->__getLastRequest();
        file_put_contents('portBiletRequest.xml', $request);

        $response = $soapClient->__getLastResponse();
        file_put_contents('portBiletResponse.xml', $response);

        dd($response);
    }


    public function test_status_booking_portbilet(): void
    {
        $this->markTestSkipped();

        list($soapClient, $apiCredentials) = (new TripsFetcherService())->initSoapClient();

        $bookingNumber = "23198894";

        $response = (new TripsFetcherService())->getStatusBooking($bookingNumber);

        file_put_contents('portBiletBookingStatus.xml', $response);
        dd($response);
    }

}
