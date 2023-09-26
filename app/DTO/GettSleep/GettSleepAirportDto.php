<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class GettSleepAirportDto extends BaseDto
{
    public string $iata;
    public string $name;
    public string $countryCode;
    public ?string $cityCode;
    public ?string $timeZone;
    public bool $flightable;
    public ?string $englishName;
    #[CastWith(ArrayCaster::class, GettSleepTerminalDto::class)]
    public ?Collection $terminals;
}
