<?php

namespace App\Services\Interfaces;

use App\DTO\Booking\BookingBaseDto;
use App\DTO\Booking\BookingCreateDto;
use App\DTO\Payment\PaymentBaseDto;

interface BookingServiceInterface extends BaseServiceInterface
{
    /**
     * @param int|string $serviceId
     * @param BookingCreateDto $data
     * @param null|string $returnUrl
     * @return PaymentBaseDto|BookingBaseDto
     */
    public function bookService(int|string $serviceId, BookingCreateDto $data, ?string $returnUrl = null): PaymentBaseDto|BookingBaseDto;
}
