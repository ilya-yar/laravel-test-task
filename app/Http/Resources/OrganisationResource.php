<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *    schema="OrganisationResource",
 *    title="Organisation",
 *    type="object",
 *    @OA\Property(
 *      property="id",
 *      type="integer",
 *      example=1
 *    ),
 *    @OA\Property(
 *      property="title",
 *      type="string",
 *      example="Название огранизации"
 *    ),
 *    @OA\Property(
 *      property="phones",
 *      type="array",
 *      @OA\Items(type="string", example="+79109698891"),
 *    ),
 *  )
 */
class OrganisationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request)
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
            ]),
            'phones' => $this->phones
        ];
    }

    public static function newCollection($resource): OrganisationCollection
    {
        return new OrganisationCollection($resource);
    }
}
