<?php

namespace App\Services;

use App\DTO\Payment\PaymentBaseDto;
use App\Enums\PaymentStatusEnum;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\Interfaces\PaymentServiceInterface;
use App\Services\Interfaces\PaymentSystemServiceInterface;

class PaymentService extends BaseService implements PaymentServiceInterface
{
    /**
     * @param PaymentRepositoryInterface $repository
     * @param BookingRepositoryInterface $bookingRepository
     * @param PaymentSystemServiceInterface $paymentSystemService
     */
    public function __construct(
        private PaymentRepositoryInterface $repository,
        private BookingRepositoryInterface $bookingRepository,
        private PaymentSystemServiceInterface $paymentSystemService
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param string $uuid
     * @return PaymentBaseDto
     */
    public function complete(string $uuid): PaymentBaseDto
    {
        $payment = $this->paymentSystemService->complete($uuid);
        if ($payment->status === PaymentStatusEnum::SUCCESSFUL) {
            $this->bookingRepository->update($payment->bookingId, ['is_paid' => true]);
        }

        return $payment;
    }
}
