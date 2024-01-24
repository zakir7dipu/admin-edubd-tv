<?php

namespace Module\ExamManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\ExamManagement\Models\ExamChapter;
use Module\ExamManagement\Models\ExamQuiz;

class ExamQuizResource extends JsonResource
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
            'id'                        => $this->id,
            'title'                     => $this->title,
            'description'               => $this->description,
            'marks'                     =>$this->marks,
            'quizOptions'               => ExamQuizOptionsResource::collection(
                                        $this->whenLoaded('quizOptions')
            ),
            'examChapter'               => [
                'id'                    => optional($this->examChapters)->id,
                'name'                  => optional($this->examChapters)->name,
                'totalQuiz'             => optional($this->examChapters)->examQuizzes,

            ],
        ];
    }
}
