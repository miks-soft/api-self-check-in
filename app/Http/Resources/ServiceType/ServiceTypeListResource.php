<?php

namespace App\Http\Resources\ServiceType;

use App\DTO\ServiceType\ServiceTypeBaseDto;
use App\DTO\ServiceType\ServiceTypeDataBaseDto;
use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceTypeListResource extends JsonResource
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

        /** @var JsonResource|ServiceTypeBaseDto $this */
        /** @var ?ServiceTypeDataBaseDto $data */
        $data = $language ? $this->data?->where('langId', $language->id)->first() : null;

        return [
            'id' => $this->id,
            'name' => $this->when($data, $data?->name),
        ];
    }
}
