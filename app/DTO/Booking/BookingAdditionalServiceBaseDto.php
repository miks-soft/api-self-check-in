<?php

namespace App\DTO\Booking;

use App\DTO\BaseDto;
use App\DTO\Service\ServiceBaseDto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class BookingAdditionalServiceBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('booking_id')]
    public int $bookingId;
    #[MapFrom('service_id')]
    public int $serviceId;
    public ?ServiceBaseDto $service;
    public int $count;
    public int $price;
    public int $total;
    public ?string $currency;
}
