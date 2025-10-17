<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'coords' => [
                'lat' => $this->latitude,
                'lon' => $this->longitude
            ],
            'companies' => OrganisationResource::collection($this->whenLoaded('organisations')),
            'distance' => $this->when(isset($this->distance), $this->distance)
        ];
    }
}
