<?php

namespace App\DTO;

use Illuminate\Support\Collection;

class PaginatedDtoCollection extends BaseDto
{
    public Collection $items;
    public PaginatorDto $paginator;
}
