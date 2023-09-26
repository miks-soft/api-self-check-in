<?php

namespace App\Http\Controllers\Api;

use App\DTO\Service\ServiceFilterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceFilterRequest;
use App\Http\Resources\Airport\AirportViewResource;
use App\Http\Resources\Service\ServicePaginatedListResource;
use App\Http\Resources\Service\ServiceSearchResultResource;
use App\Services\Interfaces\AirportServiceInterface;
use App\Services\Interfaces\ServiceServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @group Airports
 */
class AirportController extends Controller
{
    /**
     * @param AirportServiceInterface $service
     * @param ServiceServiceInterface $serviceService
     */
    public function __construct(
        private AirportServiceInterface $service,
        private ServiceServiceInterface $serviceService
    )
    {
    }

    /**
     * View airport by ID
     *
     * @param int $id
     * @return JsonResource
     *
     * @responseFile storage/responses/airport/success.airport.view.json
     */
    public function show(int $id): JsonResource
    {
        return new AirportViewResource($this->service->findByIdWith($id, 'terminals'));
    }

    /**
     * Search services with filter by airport ID
     *
     * @param int $id
     * @param ServiceFilterRequest $request
     * @return JsonResource
     * @throws UnknownProperties
     *
     * @queryParam lang string Example: en
     * @queryParam type_id integer[] Example: [1,2]
     * @queryParam terminal_id integer Example: 1
     * @queryParam date_from string Example: 2022-10-20T11:20:17.000000Z
     * @queryParam date_to string Example: 2022-10-21T11:20:17.000000Z
     * @queryParam duration integer Example: 24
     * @responseFile storage/responses/service/success.service.search-result.json
     */
    public function searchServices(int $id, ServiceFilterRequest $request): JsonResource
    {
        $filter = new ServiceFilterDto($request->only(['type_id', 'terminal_id', 'date_from', 'date_to', 'duration']));

        return new ServiceSearchResultResource($this->serviceService->searchInAirport($id, $filter, ['data', 'type.data', 'airport', 'terminal', 'tariffs'], 24));
    }

    /**
     * List all services with filter by airport ID
     *
     * @param int $id
     * @param ServiceFilterRequest $request
     * @return JsonResource
     * @throws UnknownProperties
     *
     * @queryParam lang string Example: en
     * @queryParam page integer Example: 1
     * @queryParam per_page integer Example: 10
     * @queryParam type_id integer[] Example: [1,2]
     * @queryParam terminal_id integer Example: 1
     * @queryParam date_from string Example: 2022-10-20T11:20:17.000000Z
     * @queryParam date_to string Example: 2022-10-21T11:20:17.000000Z
     * @queryParam duration integer Example: 24
     * @responseFile storage/responses/service/success.service.paginated-list.json
     */
    public function listServices(int $id, ServiceFilterRequest $request): JsonResource
    {
        $filter = new ServiceFilterDto($request->only(['type_id', 'terminal_id', 'date_from', 'date_to', 'duration']));

        return new ServicePaginatedListResource($this->serviceService->findByAirportId($id, $filter, ['data', 'type.data', 'airport', 'terminal', 'tariffs'], $request->query('per_page', 24)));
    }
}
