<?php

namespace App\Http\Resources\Booking;

use App\DTO\Booking\BookingBaseDto;
use App\Http\Resources\Service\ServiceListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|BookingBaseDto $this */
        return [
            'id' => $this->id,
            'service' => $this->when($this->service, new ServiceListResource($this->service)),
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'duration' => $this->duration,
            'name' => $this->name,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'email' => $this->email,
            'age' => $this->age->value,
            'flight' => $this->flight,
            'departure' => $this->departure,
            'payment' => $this->payment->value,
            'count' => $this->count,
            'price' => $this->price,
            'total' => $this->total,
            'currency' => $this->currency,
            'is_paid' => $this->isPaid,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'additional' => $this->when($this->additional, BookingAdditionalServiceListResource::collection($this->additional)),
        ];
    }
}
