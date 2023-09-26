<?php

namespace App\DTO\Payment;

use App\DTO\BaseDto;
use App\Enums\PaymentStatusEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\EnumCaster;

class PaymentBaseDto extends BaseDto
{
    public int $id;
    public string $uuid;
    #[MapFrom('booking_id')]
    public int $bookingId;
    public string $url;
    public ?array $data;
    #[CastWith(EnumCaster::class, PaymentStatusEnum::class)]
    public PaymentStatusEnum $status;
}
