<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface AirportServiceInterface extends BaseServiceInterface
{
    /**
     * @param int|string $countryId
     * @return Collection
     */
    public function findByCountryId(int|string $countryId): Collection;

    /**
     * @return void
     */
    public function synchronizeWithGettSleepApi();
}
