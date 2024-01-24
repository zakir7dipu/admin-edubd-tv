<?php

namespace Module\WebsiteCMS\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id'                => $this->id,
            'courseId'          => $this->course_id,
            'title'             => $this->title,
            'shortDescription'  => $this->short_description,
            'image'             => $this->image != null && file_exists($this->image) ? $this->image : null,
            'link'              => $this->link,
            'course'            => [
                'courseTitle'   => optional($this->course)->title,
                'courseSlug'    => optional($this->course)->slug,
            ]
        ];
    }
}
