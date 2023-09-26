<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentViewResource;
use App\Services\Interfaces\PaymentServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Payments
 */
class PaymentController extends Controller
{
    /**
     * @param PaymentServiceInterface $service
     */
    public function __construct(
        private PaymentServiceInterface $service
    )
    {
    }

    /**
     * Complete payment by UUID
     *
     * @param string $uuid
     * @return JsonResource
     *
     * @responseFile storage/responses/payment/success.payment.view.json
     */
    public function complete(string $uuid): JsonResource
    {
        return new PaymentViewResource($this->service->complete($uuid));
    }
}
