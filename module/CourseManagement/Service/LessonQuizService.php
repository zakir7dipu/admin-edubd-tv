<?php

namespace Module\CourseManagement\Service;

use Carbon\Carbon;
use App\Traits\FileUploader;
use Module\CourseManagement\Models\LessonQuiz;

class LessonQuizService
{
    use FileUploader;
    public $lessonQuiz;


    public function storeLessonQuiz($request)
    {
        $this->lessonQuiz       = LessonQuiz::create([
            'lesson_id'         => $request->lesson_id,
            'name'              => $request->quiz_name,
            'status'            => $request->status ?? 0,

        ]);
    }





    public function updateLessonQuiz($request, $lesson_quiz)
    {
        $lesson_quiz->update([
            'lesson_id'         => $request->lesson_id,
            'name'              => $request->quiz_name,
            'status'            => $request->status ?? 0,
        ]);

        $this->lessonQuiz = $lesson_quiz->refresh();
    }


    public function updateOrCreateLessonQuizOptions($request)
    {
        foreach ($request->option_name ?? [] as $key => $option_name) {

            $option_id = isset($request->option_id[$key]) ? $request->option_id[$key] : null;

            $this->lessonQuiz->lessonQuizOption()->updateOrCreate([
                'id'        => $option_id
            ],[
                'name'      => $option_name,
                'answer'   => $request->option_is_true[$key] ?? 0,
            ]);
        }
    }





}
