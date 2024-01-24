<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseIntroductionResource extends JsonResource
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
            'id'    => $this->id,
            'icon'  => $this->icon,
            'text'  => $this->text,
        ];
    }
}
