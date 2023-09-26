<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class GettSleepServiceDto extends BaseDto
{
    public string $id;
    public string $type;
    public string $name;
    public ?string $description;
    public ?bool $sterile;
    public ?int $count;
    public ?string $cancellationCondition;
    public ?string $phoneNumber;
    public ?array $photos;
    public ?string $mapLink;
    public ?string $commission;
    public ?string $airportIata;
    public ?string $terminal;
    public ?string $terminalDescription;
    public ?GettSleepTariffDto $tariff;
    #[CastWith(ArrayCaster::class, GettSleepTariffDto::class)]
    public ?Collection $availableTariffs;
    #[CastWith(ArrayCaster::class, GettSleepServiceDto::class)]
    public ?Collection $childServices;
}
