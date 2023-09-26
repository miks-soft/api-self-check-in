<?php

namespace App\Http\Resources\Airport;

use App\DTO\Airport\AirportBaseDto;
use Illuminate\Http\Resources\Json\JsonResource;

class AirportListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|AirportBaseDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
