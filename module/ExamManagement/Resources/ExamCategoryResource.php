<?php

namespace Module\ExamManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamCategoryResource extends JsonResource
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
            'parentId'          => $this->parent_id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'shortDescription'  => $this->short_description,
            'totalExam'         => $this->whenLoaded('exams', function() {
                                    return $this->exams->count();
                                }),
            'totalChilds'       => $this->whenLoaded('exams', function() {
                                    return $this->childExamCategories->count();
                                }),
        ];
    }
}
