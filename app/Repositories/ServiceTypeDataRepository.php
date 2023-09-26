<?php

namespace App\Repositories;

use App\DTO\ServiceType\ServiceTypeDataBaseDto;
use App\Models\ServiceTypeData;
use App\Repositories\Interfaces\ServiceTypeDataRepositoryInterface;

class ServiceTypeDataRepository extends BaseEloquentRepository implements ServiceTypeDataRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(ServiceTypeData::class, ServiceTypeDataBaseDto::class);
    }
}
