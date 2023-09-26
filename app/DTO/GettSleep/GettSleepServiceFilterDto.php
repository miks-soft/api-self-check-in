<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Carbon\Carbon;

class GettSleepServiceFilterDto extends BaseDto
{
    public ?string $lang;
    public ?Carbon $arrival;
    public ?Carbon $depart;
    public ?string $iata;
    public ?string $terminal;
    public ?bool $sterile;
    public ?int $adultsCount;
}
