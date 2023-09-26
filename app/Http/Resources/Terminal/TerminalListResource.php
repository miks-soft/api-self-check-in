<?php

namespace App\Http\Resources\Terminal;

use App\DTO\Terminal\TerminalBaseDto;
use Illuminate\Http\Resources\Json\JsonResource;

class TerminalListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var JsonResource|TerminalBaseDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
