<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;

class GettSleepTariffDto extends BaseDto
{
    public string $id;
    public ?string $serviceId;
    public ?int $babyPrice;
    public ?int $childPrice;
    public int $adultPrice;
    public ?int $duration;
    public ?bool $night;
    public ?string $description;
}
