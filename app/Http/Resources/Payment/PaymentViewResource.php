<?php

namespace App\Http\Resources\Payment;

use App\DTO\Payment\PaymentBaseDto;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|PaymentBaseDto $this */
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'booking_id' => $this->bookingId,
            'url' => $this->url,
            'status' => $this->status->value,
        ];
    }
}
