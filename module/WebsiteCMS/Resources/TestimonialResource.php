<?php

namespace Module\WebsiteCMS\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'designation'   => $this->designation,
            'country'       => $this->country,
            'description'   => $this->description,
            'image'         => $this->image != null && file_exists($this->image) ? $this->image : null,
            'rating'        => $this->rating,
        ];
    }
}
