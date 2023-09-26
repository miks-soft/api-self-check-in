<?php

namespace App\Repositories;

use App\DTO\Service\ServiceDataBaseDto;
use App\Models\ServiceData;
use App\Repositories\Interfaces\ServiceDataRepositoryInterface;

class ServiceDataRepository extends BaseEloquentRepository implements ServiceDataRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(ServiceData::class, ServiceDataBaseDto::class);
    }
}
