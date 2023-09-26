<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class GettSleepBookServiceResponseDto extends BaseDto
{
    public string $id;
    public string $status;
    public int $total;
    #[CastWith(ArrayCaster::class, GettSleepBookServiceGuestDto::class)]
    public Collection $guests;
}
