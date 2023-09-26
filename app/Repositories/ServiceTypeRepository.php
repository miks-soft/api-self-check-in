<?php

namespace App\Repositories;

use App\DTO\ServiceType\ServiceTypeBaseDto;
use App\Models\ServiceType;
use App\Repositories\Interfaces\ServiceTypeRepositoryInterface;

class ServiceTypeRepository extends BaseEloquentRepository implements ServiceTypeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(ServiceType::class, ServiceTypeBaseDto::class);
    }
}
