<?php

namespace App\Http\Resources\Service;

use App\DTO\PaginatedDtoCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicePaginatedListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|PaginatedDtoCollection $this */
        return [
            'items' => ServiceListResource::collection($this->items),
            'total' => $this->paginator->total,
            'page' => $this->paginator->page,
            'per_page' => $this->paginator->perPage,
            'last_page' => $this->paginator->lastPage,
        ];
    }
}
