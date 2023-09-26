<?php

namespace App\DTO\Service;

use App\DTO\BaseDto;
use Illuminate\Support\Collection;

class ServiceSearchResultDto extends BaseDto
{
    public int $total;
    public Collection $items;
}
