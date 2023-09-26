<?php

namespace App\Http\Resources\Service;

use App\DTO\Service\ServiceSearchResultItemDto;
use App\Http\Resources\ServiceType\ServiceTypeListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSearchResultItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|ServiceSearchResultItemDto $this */
        return [
            'type' => new ServiceTypeListResource($this->type),
            'total' => $this->total,
            'items' => ServiceListResource::collection($this->items),
        ];
    }
}
