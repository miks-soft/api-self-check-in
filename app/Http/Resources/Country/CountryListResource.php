<?php

namespace App\Http\Resources\Country;

use App\DTO\Country\CountryBaseDto;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|CountryBaseDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
