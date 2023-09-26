<?php

namespace App\Services;

use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Services\Interfaces\CountryServiceInterface;

class CountryService extends BaseService implements CountryServiceInterface
{
    /**
     * @param CountryRepositoryInterface $repository
     */
    public function __construct(
        private CountryRepositoryInterface $repository
    )
    {
        parent::__construct($repository);
    }
}
