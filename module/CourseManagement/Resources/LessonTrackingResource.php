<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonTrackingResource extends JsonResource
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
            'student_id'        =>$thiss->student_id,
            'course_id'         => $this->course_id,
            'lesson_id'         => $this->lesson_id,
            'is_completed'     => $this->is_completed,
        ];
    }
}
