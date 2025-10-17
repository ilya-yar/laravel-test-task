<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="Organisation")
 */
class OrganisationResource extends JsonResource
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
            'building' => BuildingResource::make($this->whenLoaded('building')),
            'business' => BusinessResource::collection($this->whenLoaded('business')),
            'distance' => $this->when(isset($this->distance), $this->distance),
            'coords' => $this->when(isset($this->latitude, $this->longitude), [
                'lat' => $this->latitude,
                'lon' => $this->longitude
            ])
        ];
    }

    public static function newCollection($resource): OrganisationCollection
    {
        return new OrganisationCollection($resource);
    }
}
