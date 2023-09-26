<?php

namespace App\DTO\Airport;

use App\DTO\BaseDto;
use App\DTO\Terminal\TerminalBaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class AirportBaseDto extends BaseDto
{
    public int $id;
    public string $iata;
    public string $name;
    #[CastWith(ArrayCaster::class, TerminalBaseDto::class)]
    public ?Collection $terminals;
}
