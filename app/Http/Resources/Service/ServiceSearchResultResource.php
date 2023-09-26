<?php

namespace App\Http\Resources\Service;

use App\DTO\Service\ServiceSearchResultDto;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSearchResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|ServiceSearchResultDto $this */
        return [
            'total' => $this->total,
            'items' => ServiceSearchResultItemResource::collection($this->items),
        ];
    }
}
