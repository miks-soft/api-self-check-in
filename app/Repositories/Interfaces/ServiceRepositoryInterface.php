<?php

namespace App\Repositories\Interfaces;

use App\DTO\PaginatedDtoCollection;
use App\DTO\Service\ServiceFilterDto;
use Closure;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int|string $airportId
     * @param ServiceFilterDto $filter
     * @param null|array|string $relations
     * @return Collection
     */
    public function searchInAirport(int|string $airportId, ServiceFilterDto $filter, null|array|string $relations = null): Collection;

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
}
