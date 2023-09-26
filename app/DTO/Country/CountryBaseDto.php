<?php

namespace App\DTO\Country;

use App\DTO\Airport\AirportBaseDto;
use App\DTO\BaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class CountryBaseDto extends BaseDto
{
    public int $id;
    public string $name;
    #[CastWith(ArrayCaster::class, AirportBaseDto::class)]
    public ?Collection $airports;
}
