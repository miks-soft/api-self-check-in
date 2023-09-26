<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class GettSleepBookServiceDto extends BaseDto
{
    public string $serviceId;
    public string $tariffId;
    public string $flight;
    public int $count;
    public Carbon $arrival;
    public Carbon $departure;
    public GettSleepBookServiceContactDto $contact;
    #[CastWith(ArrayCaster::class, GettSleepBookServiceGuestDto::class)]
    public Collection $guests;
}
