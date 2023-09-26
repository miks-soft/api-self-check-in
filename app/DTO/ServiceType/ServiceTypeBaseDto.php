<?php

namespace App\DTO\ServiceType;

use App\DTO\BaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class ServiceTypeBaseDto extends BaseDto
{
    public int $id;
    public string $slug;
    #[CastWith(ArrayCaster::class, ServiceTypeDataBaseDto::class)]
    public ?Collection $data;
}
