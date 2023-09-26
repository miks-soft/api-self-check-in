<?php

namespace App\Repositories;

use App\DTO\Payment\PaymentBaseDto;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository extends BaseEloquentRepository implements PaymentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Payment::class, PaymentBaseDto::class);
    }
}
