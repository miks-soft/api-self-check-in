<?php

namespace App\Http\Resources\Service;

use App\DTO\Service\ServiceBaseDto;
use App\DTO\Service\ServiceDataBaseDto;
use App\Http\Resources\Airport\AirportListResource;
use App\Http\Resources\ServiceType\ServiceTypeListResource;
use App\Http\Resources\Terminal\TerminalListResource;
use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $language = Language::where('code', app()->getLocale())->first();

        /** @var JsonResource|ServiceBaseDto $this */
        /** @var ?ServiceDataBaseDto $data */
        $data = $language ? $this->data?->where('langId', $language->id)->first() : null;

        $tariff = $this->getTariff($request->input('duration'));

        return [
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'type' => $this->when($this->type, new ServiceTypeListResource($this->type)),
            'airport' => $this->when($this->airport, new AirportListResource($this->airport)),
            'terminal' => $this->when($this->terminal, new TerminalListResource($this->terminal)),
            'slug' => $this->slug,
            'image' => $this->image,
            'count' => $this->count,
            'duration' => $tariff?->duration,
            'price' => $tariff?->price,
            'currency' => $tariff?->currency,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,

            $this->mergeWhen($data, [
                'name' => $data?->name,
                'description' => $data?->description,
            ]),
        ];
    }
}
