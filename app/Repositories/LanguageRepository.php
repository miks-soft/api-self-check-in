<?php

namespace App\Repositories;

use App\DTO\Language\LanguageBaseDto;
use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository extends BaseEloquentRepository implements LanguageRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Language::class, LanguageBaseDto::class);
    }
}
