<?php

namespace Module\ExamManagement\Service;


use Illuminate\Support\Str;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Hash;
use Module\ExamManagement\Models\Exam;
use Module\ExamManagement\Models\ExamChapter;
use Module\ExamManagement\Models\ExamQuiz;
use Module\ExamManagement\Models\QuizTest;

class ExamService
{
    use FileUploader;

    public $exam;
    public $quizTest;





    public function updateOrCreateExam($request, $id = null)
    {

        $this->exam   = Exam::updateOrCreate([
            'id'           => $id,

        ], [
            'title'         => $request->title,
            'exam_category_id'       => $request->exam_category_id,
            // 'exam_type_id'           => $request->exam_type_id,
            'exam_year_id'           => $request->exam_year_id,
            'institute_id'           => $request->institute_id,
            'slug'                  => $request->slug,
            'description'      => $request->description ?? null,
            'serial_no'      => $request->serial_no,

            'status'        => $request->status ?? 0,
        ]);
    }




    public function storeExamChapter($request)
    {

        foreach ($request->chapterName ?? [] as $key => $chapterName) {

            $chapter_id = isset($request->chapter_id[$key]) ? $request->chapter_id[$key] : null;

            $this->exam->examChapters()->updateOrCreate([
                'id'        => $chapter_id
            ], [
                'name'      => $chapterName,
                'slug'      => $request->chapterSlug[$key],
                'duration'  => $request->duration[$key],
                'status' => $request->status[$key] ?? 0,
                'is_published' => $request->is_published[$key] ?? 0,
            ]);
        }
    }



    public function updateOrCreateQuizTest($request, $id = null)
    {

        $this->quizTest   = QuizTest::updateOrCreate([
            'id'                    => $id,

        ], [
            'student_id'            => $request->student_id ?? null,
            'chapter_id'            => $request->chapter_id ?? null,
            // 'exam_type_id'           => $request->exam_type_id,
            'total_quiz'            => $request->total_quiz ?? null,
            'total_marks'           => $request->total_marks ?? 0,
            'time_spent'            => $request->time_spent ?? null,
            'is_completed'          => $request->is_completed ?? null,

        ]);
    }

    public function updateOrCreateQuizTestQuizzes($request, $id = null)
    {
        $quizTestId = QuizTest::find($id)->get();
        $quizId = ExamQuiz::find($id)->get();

        $this->quizTest->quizTestQuizzes()->updateOrCreate([

            'quiz_test_id'      => $quizTestId,
            'quiz_id'           => $quizId,
            'mark'              => $request->mark ?? 0,
        ]);
    }
}
