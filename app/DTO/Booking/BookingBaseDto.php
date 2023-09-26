<?php

namespace App\DTO\Booking;

use App\DTO\BaseDto;
use App\DTO\Service\ServiceBaseDto;
use App\Enums\AgeEnum;
use App\Enums\PaymentEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;

class BookingBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('service_id')]
    public int $serviceId;
    public ?ServiceBaseDto $service;
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
    public int $price;
    public int $total;
    public ?string $currency;
    #[MapFrom('is_paid')]
    public bool $isPaid;
    #[MapFrom('gettsleep_id')]
    public ?string $gettSleepId;
    #[MapFrom('gettsleep_status')]
    public ?string $gettSleepStatus;
    #[MapFrom('created_at')]
    public Carbon $createdAt;
    #[MapFrom('updated_at')]
    public Carbon $updatedAt;
    #[CastWith(ArrayCaster::class, BookingAdditionalServiceBaseDto::class)]
    public ?Collection $additional;
}
