<?php

namespace Module\ExamManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'examCategoryId'    => $this->exam_category_id,
            'examTypeId'        => $this->exam_type_id,
            'examYearId'        => $this->exam_year_id,
            'instituteId'       => $this->institute_id,
            'title'             => $this->title,
            'slug'              => $this->slug,
            'description'       => $this->description,
            'examFee'           => $this->exam_fee,
            'category'          => [
                                    'id'                => optional($this->examCategory)->id,
                                    'parentId'          => optional($this->examCategory)->parent_id,
                                    'name'              => optional($this->examCategory)->name,
                                    'slug'              => optional($this->examCategory)->slug,
                                    'shortDescription'  => optional($this->examCategory)->short_description,
                                ],
            'type'              => [
                                    'id'                => optional($this->examType)->id,
                                    'type'              => optional($this->examType)->type,
                                ],
            'year'              => [
                                    'id'                => optional($this->examYear)->id,
                                    'year'              => optional($this->examYear)->year,
                                ],
            'institute'         => [
                                    'id'                => optional($this->institute)->id,
                                    'name'              => optional($this->institute)->name,
                                    'shortForm'         => optional($this->institute)->short_form,
                                ],
            'examChapters'      => ExamChapterResource::collection(
                                    $this->whenLoaded('examChapters')
                                ),
            'examQuizzes'       => ExamQuizResource::collection(
                                    $this->whenLoaded('examQuizzes')
                                ),
        ];
    }
}
