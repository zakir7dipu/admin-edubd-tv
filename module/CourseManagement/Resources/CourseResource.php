<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'categoryId'        => $this->course_category_id,
            'levelId'           => $this->course_level_id,
            'languageId'        => $this->course_language_id,
            'courseType'        => $this->course_type,
            'title'             => $this->title,
            'slug'              => $this->slug,
            'shortDescription'  => $this->short_description,
            'totalLecture'      => $this->total_lecture,
            'totalDuration'     => $this->total_duration,
            'thumbnailImage'    => $this->thumbnail_image != null && file_exists($this->thumbnail_image) ? $this->thumbnail_image : null,
            'thumbnailImageBig'    => $this->thumbnail_image_big != null && file_exists($this->thumbnail_image_big) ? $this->thumbnail_image_big : null,
            'introVideo'        => $this->intro_video,
            'regularFee'        => $this->regular_fee,
            'discountAmount'    => $this->discount_amount,
            'courseFee'         => $this->course_fee,
            'averageRating'     => $this->average_rating,
            'isSlider'          => $this->is_slider,
            'isPremier'         => $this->is_premier,
            'publishedBy'       => optional($this->publishedBy)->first_name . ' ' . optional($this->publishedBy)->last_name,
            'publishedAt'       => $this->published_at,
            'category'          => [
                                    'id'                => optional($this->category)->id,
                                    'parentId'          => optional($this->category)->parent_id,
                                    'name'              => optional($this->category)->name,
                                    'slug'              => optional($this->category)->slug,
                                    'shortDescription'  => optional($this->category)->short_description,
                                ],
            'level'             => [
                                    'id'                => optional($this->level)->id,
                                    'name'              => optional($this->level)->name,
                                ],
            'language'          => [
                                    'id'                => optional($this->language)->id,
                                    'name'              => optional($this->language)->name,
                                ],
            'introductions'     => CourseIntroductionResource::collection(
                                    $this->whenLoaded('courseIntroductions')
                                ),
            'outcomes'          => CourseOutcomeResource::collection(
                                    $this->whenLoaded('courseOutcomes')
                                ),
            'faqs'              => CourseFAQResource::collection(
                                    $this->whenLoaded('courseFAQs')
                                ),
            'topics'            => CourseTopicResource::collection(
                                    $this->whenLoaded('coursePublishedActiveTopics')
                                ),
            'lessons'           => CourseLessonResource::collection(
                                    $this->whenLoaded('coursePublishedActiveLessons')
                                )
        ];
    }
}
