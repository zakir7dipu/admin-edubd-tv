<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseTagResource extends JsonResource
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
            'id'        => $this->id,
            'course_id' => $this->course_id,
            'tag_id'    => $this->tag_id,
            'courses'   => CourseResource::collection(
                $this->whenLoaded('courses')
            ),
        ];
    }
}
