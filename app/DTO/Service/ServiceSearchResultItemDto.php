<?php

namespace App\DTO\Service;

use App\DTO\BaseDto;
use App\DTO\ServiceType\ServiceTypeBaseDto;
use Illuminate\Support\Collection;

class ServiceSearchResultItemDto extends BaseDto
{
    public ServiceTypeBaseDto $type;
    public int $total;
    public Collection $items;
}
