<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface AirportRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int|string $countryId
     * @return Collection
     */
    public function findByCountryId(int|string $countryId): Collection;
}
