<?php

namespace App\DTO\ServiceType;

use App\DTO\BaseDto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ServiceTypeDataBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('type_id')]
    public int $typeId;
    #[MapFrom('lang_id')]
    public int $langId;
    public string $name;
}
