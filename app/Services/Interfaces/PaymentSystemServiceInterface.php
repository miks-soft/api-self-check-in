<?php

namespace App\Services\Interfaces;

use App\DTO\Booking\BookingBaseDto;
use App\DTO\Payment\PaymentBaseDto;

interface PaymentSystemServiceInterface
{
    /**
     * @param BookingBaseDto $booking
     * @param null|string $returnUrl
     * @return PaymentBaseDto
     */
    public function init(BookingBaseDto $booking, ?string $returnUrl = null): PaymentBaseDto;

    /**
     * @param string $paymentUuid
     * @return PaymentBaseDto
     */
    public function complete(string $paymentUuid): PaymentBaseDto;
}
