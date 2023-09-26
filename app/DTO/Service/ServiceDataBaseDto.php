<?php

namespace App\DTO\Service;

use App\DTO\BaseDto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ServiceDataBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('service_id')]
    public int $serviceId;
    #[MapFrom('lang_id')]
    public int $langId;
    public string $name;
    public ?string $description;
}
