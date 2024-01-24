<?php

namespace Module\ExamManagement\Service;

use App\Traits\FileUploader;
use Illuminate\Database\Eloquent\Relations\Relation;
use Module\ExamManagement\Models\ExamQuiz;
use Module\ExamManagement\Models\QuizOption;

class QuizService
{
    use FileUploader;
    public $quiz;





    public function storeQuiz($request)
    {
        $this->quiz             = ExamQuiz::create([
            'exam_category_id'  => $request->exam_category_id,
            'exam_id'           => $request->exam_id,
            'chapter_id'        => $request->chapter_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'serial_no'         => $request->serial_no,
            'status'            => $request->status ?? 0,
            'marks'             => $request->marks,
        ]);
    }





    public function updateQuiz($request, $examQuiz)
    {
        $examQuiz->update([
            'exam_category_id'  => $request->exam_category_id,
            'exam_id'           => $request->exam_id,
            'chapter_id'        => $request->chapter_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'serial_no'         => $request->serial_no,
            'status'            => $request->status ?? 0,
            'marks'             => $request->marks
        ]);

        $this->quiz = $examQuiz->refresh();
    }





    public function updateOrCreateQuizOptions($request)
    {
        foreach ($request->option_name ?? [] as $key => $option_name) {

            $option_id = isset($request->option_id[$key]) ? $request->option_id[$key] : null;

            $this->quiz->quizOptions()->updateOrCreate([
                'id'        => $option_id
            ],[
                'name'      => $option_name,
                'is_true'   => $request->option_is_true[$key] ?? 0,
            ]);
        }
    }
}
