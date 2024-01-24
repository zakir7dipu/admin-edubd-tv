<?php

namespace Module\CourseManagement\Resources;
use Module\CourseManagement\Models\LessonTracking;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseLessonResource extends JsonResource
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
            'id'                    => $this->id,

            'courseId'              => $this->course_id,

            'topicId'               => $this->course_topic_id,

            'title'                 => $this->title,
            'duration'              => $this->duration,
            'video'                 => $this->video,
            'attachment'            => $this->attachment,
            'description'           => $this->description,
            'assignmentDescription' => $this->assignmentDescription,
            'isVideo'               => $this->is_video,
            'is_youtube_embed_link' => $this->is_youtube_embed_link,
            'isAttachment'          => $this->is_attachment,
            'isFree'                => $this->is_free,
            'isQuiz'                => $this->is_quiz,
            'isAssignment'          => $this->is_assignment,
            'publishedAt'           => $this->published_at,
            'publishedBy'           => optional($this->publishedBy)->first_name . ' ' . optional($this->publishedBy)->last_name,
            'course'                => CourseResource::collection(
                                        $this->whenLoaded('course')
                                    ),
            'courseTopics'           => CourseTopicResource::collection(
                                        $this->whenLoaded('courseTopics')
            ),
            'courseLessonTracking'   => LessonTracking::query()-> where('lesson_id',$this->id)
                                    ->where('course_id',$this->course_id)->first()
        ];
    }
}
