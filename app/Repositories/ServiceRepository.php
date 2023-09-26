<?php

namespace App\Repositories;

use App\DTO\PaginatedDtoCollection;
use App\DTO\Service\ServiceBaseDto;
use App\DTO\Service\ServiceFilterDto;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ServiceRepository extends BaseEloquentRepository implements ServiceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Service::class, ServiceBaseDto::class);
    }

    /**
     * @param int|string $airportId
     * @param ServiceFilterDto $filter
     * @param null|array|string $relations
     * @return Collection
     */
    public function searchInAirport(int|string $airportId, ServiceFilterDto $filter, null|array|string $relations = null): Collection
    {
        $query = $this->query($relations)->whereNull('parent_id')->where('airport_id', $airportId);
        $this->applyFilter($query, $filter);

        return $this->toDto($query->get());
    }

    /**
     * @param int|string $airportId
     * @param null|ServiceFilterDto $filter
     * @param null|array|string $relations
     * @param null|int|Closure $perPage
     * @param string $pageName
     * @param null|int $page
     * @return Collection|PaginatedDtoCollection
     */
    public function findByAirportId(int|string $airportId, ?ServiceFilterDto $filter = null, null|array|string $relations = null, null|int|Closure $perPage = null, string $pageName = 'page', ?int $page = null): Collection|PaginatedDtoCollection
    {
        $query = $this->query($relations)->whereNull('parent_id')->where('airport_id', $airportId);
        if ($filter) {
            $this->applyFilter($query, $filter);
        }

        return $perPage ? $this->paginate($query, $perPage, ['*'], $pageName, $page) : $this->toDto($query->get());
    }

    /**
     * @param Builder $query
     * @param ServiceFilterDto $filter
     * @return Builder
     */
    private function applyFilter(Builder $query, ServiceFilterDto $filter): Builder
    {
        $query->when($filter->duration, function (Builder $query) use ($filter) {
            $query->whereHas('tariffs', function (Builder $query) use ($filter) {
                $query->whereNull('duration')->orWhere('duration', '>=', $filter->duration);
            });
        });

        $query->when($filter->typeId, fn (Builder $query) => $query->whereIn('type_id', $filter->typeId));
        $query->when($filter->terminalId, fn (Builder $query) => $query->where('terminal_id', $filter->terminalId));

        return $query;
    }
}
