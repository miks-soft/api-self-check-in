<?php

namespace App\Services;

use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Services\Interfaces\LanguageServiceInterface;

class LanguageService extends BaseService implements LanguageServiceInterface
{
    /**
     * @param LanguageRepositoryInterface $repository
     */
    public function __construct(
        private LanguageRepositoryInterface $repository
    )
    {
        parent::__construct($repository);
    }
}
