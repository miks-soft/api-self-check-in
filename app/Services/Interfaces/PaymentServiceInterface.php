<?php

namespace App\Services\Interfaces;

use App\DTO\Payment\PaymentBaseDto;

interface PaymentServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $uuid
     * @return PaymentBaseDto
     */
    public function complete(string $uuid): PaymentBaseDto;
}
