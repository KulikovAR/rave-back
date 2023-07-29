<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\SearchFlight\SearchFlightRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Interfaces\FetchFlightInterface;
use App\Services\CalculateFlightService;
use App\Services\TripsFetcherService;
use Illuminate\Support\Facades\Cache;

class SearchFlightController extends Controller
{
    public function __construct(
        public FetchFlightInterface   $fetchFlightService = new TripsFetcherService(),
        public CalculateFlightService $calculateFlightService = new CalculateFlightService()
    ) {}

    public function index(SearchFlightRequest $request)
    {
        $requestValidated = $request->validated();

        $flightStartXmlString = Cache::remember(implode('_', $requestValidated), 3000, function () use ($requestValidated) {
            return $this->fetchFlightService->fetch($requestValidated);
        });

        $flightBackXmlString = $this->getBackTickets($requestValidated);

        $flightsArr = $this->calculateFlightService
            ->calculate($requestValidated, $flightStartXmlString, $flightBackXmlString);

        return new ApiJsonResponse(200, StatusEnum::OK, data: $flightsArr);
    }

    public function getBackTickets(array $requestValidated): ?string
    {
        $dateBack    = $requestValidated['date_back'];
        $airportTo   = $requestValidated['airport_from'];
        $airportFrom = $requestValidated['airport_to'];

        if (empty($dateBack)) {
            return null;
        }

        $requestValidated['date_start']   = $dateBack;
        $requestValidated['airport_to']   = $airportTo;
        $requestValidated['airport_from'] = $airportFrom;

        $flightBackXmlString = Cache::remember(implode('_', $requestValidated), 3000, function () use ($requestValidated) {
            return $this->fetchFlightService->fetch($requestValidated);
        });

        return $flightBackXmlString;
    }
}
