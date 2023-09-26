<?php

namespace App\Repositories;

use App\DTO\Service\ServiceTariffBaseDto;
use App\Models\ServiceTariff;
use App\Repositories\Interfaces\ServiceTariffRepositoryInterface;

class ServiceTariffRepository extends BaseEloquentRepository implements ServiceTariffRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(ServiceTariff::class, ServiceTariffBaseDto::class);
    }
}
