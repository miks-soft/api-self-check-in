<?php

namespace App\DTO\Booking;

use App\DTO\BaseDto;
use App\Enums\AgeEnum;
use App\Enums\PaymentEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;

class BookingCreateDto extends BaseDto
{
    #[MapFrom('date_from')]
    public Carbon $dateFrom;
    #[MapFrom('date_to')]
    public Carbon $dateTo;
    public int $duration;
    public string $name;
    #[MapFrom('last_name')]
    public string $lastName;
    public string $phone;
    public string $email;
    #[CastWith(EnumCaster::class, AgeEnum::class)]
    public AgeEnum $age;
    public string $flight;
    public Carbon $departure;
    #[CastWith(EnumCaster::class, PaymentEnum::class)]
    public PaymentEnum $payment;
    public int $count;
    #[CastWith(ArrayCaster::class, BookingCreateAdditionalServiceDto::class)]
    public ?Collection $additional;
}
