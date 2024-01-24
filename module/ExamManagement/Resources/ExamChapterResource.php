<?php

namespace Module\ExamManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamChapterResource extends JsonResource
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
            'name'  => $this->name,
            'slug'  => $this->slug,
            'totalQuiz' => $this->examQuiz,
            'examQuiz'     => ExamQuizResource::collection(
                $this->whenLoaded('examQuiz')
            ),
        ];
    }
}
