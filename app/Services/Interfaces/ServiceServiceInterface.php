<?php

namespace App\Services\Interfaces;

use App\DTO\PaginatedDtoCollection;
use App\DTO\Service\ServiceFilterDto;
use App\DTO\Service\ServiceSearchResultDto;
use Closure;
use Illuminate\Support\Collection;

interface ServiceServiceInterface extends BaseServiceInterface
{
    /**
     * @param int|string $airportId
     * @param ServiceFilterDto $filter
     * @param null|array|string $relations
     * @param null|int $limit
     * @return ServiceSearchResultDto
     */
    public function searchInAirport(int|string $airportId, ServiceFilterDto $filter, null|array|string $relations = null, null|int $limit = null): ServiceSearchResultDto;

    /**
     * @param int|string $airportId
     * @param null|ServiceFilterDto $filter
     * @param null|array|string $relations
     * @param null|int|Closure $perPage
     * @param string $pageName
     * @param null|int $page
     * @return Collection|PaginatedDtoCollection
     */
    public function findByAirportId(int|string $airportId, ?ServiceFilterDto $filter = null, null|array|string $relations = null, null|int|Closure $perPage = null, string $pageName = 'page', ?int $page = null): Collection|PaginatedDtoCollection;

    /**
     * @return void
     */
    public function synchronizeWithGettSleepApi();
}
