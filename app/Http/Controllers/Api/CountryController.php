<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Airport\AirportListResource;
use App\Http\Resources\Country\CountryListResource;
use App\Services\Interfaces\AirportServiceInterface;
use App\Services\Interfaces\CountryServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Countries
 */
class CountryController extends Controller
{
    /**
     * @param CountryServiceInterface $service
     * @param AirportServiceInterface $airportService
     */
    public function __construct(
        private CountryServiceInterface $service,
        private AirportServiceInterface $airportService
    )
    {
    }

    /**
     * List all countries
     *
     * @return JsonResource
     *
     * @responseFile storage/responses/country/success.country.list.json
     */
    public function index(): JsonResource
    {
        return CountryListResource::collection($this->service->all());
    }

    /**
     * List all airports by country ID
     *
     * @param int $id
     * @return JsonResource
     *
     * @responseFile storage/responses/airport/success.airport.list.json
     */
    public function listAirports(int $id): JsonResource
    {
        return AirportListResource::collection($this->airportService->findByCountryId($id));
    }
}
