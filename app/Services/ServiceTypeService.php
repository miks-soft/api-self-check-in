<?php

namespace App\Services;

use App\Repositories\Interfaces\ServiceTypeRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\ServiceTypeServiceInterface;

class ServiceTypeService extends BaseService implements ServiceTypeServiceInterface
{
    /**
     * @param ServiceTypeRepositoryInterface $repository
     */
    public function __construct(
        private ServiceTypeRepositoryInterface $repository
    )
    {
        parent::__construct($repository);
    }
}
