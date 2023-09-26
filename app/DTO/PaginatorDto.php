<?php

namespace App\DTO;

class PaginatorDto extends BaseDto
{
    public int $total;
    public int $page;
    public int $perPage;
    public int $lastPage;
}
