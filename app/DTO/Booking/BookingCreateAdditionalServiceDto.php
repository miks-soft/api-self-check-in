<?php

namespace App\DTO\Booking;

use App\DTO\BaseDto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class BookingCreateAdditionalServiceDto extends BaseDto
{
    #[MapFrom('service_id')]
    public int $serviceId;
    public int $count;
}
