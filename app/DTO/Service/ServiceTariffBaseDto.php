<?php

namespace App\DTO\Service;

use App\DTO\BaseDto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ServiceTariffBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('service_id')]
    public int $serviceId;
    public ?int $duration;
    public int $price;
    public ?string $currency;
    #[MapFrom('gettsleep_id')]
    public ?string $gettSleepId;
}
