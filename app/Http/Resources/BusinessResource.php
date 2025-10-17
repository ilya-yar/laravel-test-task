<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subbusiness' => BusinessResource::collection($this->whenLoaded('subbusiness')),
            'organisations' => OrganisationResource::collection($this->whenLoaded('organisations')),
        ];
    }
}
