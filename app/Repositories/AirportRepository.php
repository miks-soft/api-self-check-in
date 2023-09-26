<?php

namespace App\Repositories;

use App\DTO\Airport\AirportBaseDto;
use App\Models\Airport;
use App\Repositories\Interfaces\AirportRepositoryInterface;
use Illuminate\Support\Collection;

class AirportRepository extends BaseEloquentRepository implements AirportRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Airport::class, AirportBaseDto::class);
    }

    /**
     * @param int|string $countryId
     * @return Collection
     */
    public function findByCountryId(int|string $countryId): Collection
    {
        return $this->toDto($this->query()->where('country_id', $countryId)->get());
    }
}
