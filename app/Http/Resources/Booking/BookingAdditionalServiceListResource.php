<?php

namespace App\Http\Resources\Booking;

use App\DTO\Booking\BookingAdditionalServiceBaseDto;
use App\Http\Resources\Service\ServiceListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingAdditionalServiceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|BookingAdditionalServiceBaseDto $this */
        return [
            'id' => $this->id,
            'service' => $this->when($this->service, new ServiceListResource($this->service)),
            'count' => $this->count,
            'price' => $this->price,
            'total' => $this->total,
            'currency' => $this->currency,
        ];
    }
}
