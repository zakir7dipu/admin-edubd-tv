<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseTopicResource extends JsonResource
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
            'title'             => $this->title,
            'totalLecture'      => $this->total_lecture,
            'totalDuration'     => $this->total_duration,
            'publishedAt'       => $this->published_at,
            'publishedBy'       => optional($this->publishedBy)->first_name . ' ' . optional($this->publishedBy)->last_name,

        ];
    }
}
