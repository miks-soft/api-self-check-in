<?php

namespace App\Repositories;

use App\DTO\Country\CountryBaseDto;
use App\Models\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryRepository extends BaseEloquentRepository implements CountryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Country::class, CountryBaseDto::class);
    }
}
