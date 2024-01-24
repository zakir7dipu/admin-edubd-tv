<?php

namespace Module\ExamManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\Exam;
use Module\ExamManagement\Models\ExamCategory;
use Module\ExamManagement\Models\ExamChapter;
use Module\ExamManagement\Models\ExamQuiz;
use Module\ExamManagement\Models\QuizOption;
use Module\ExamManagement\Requests\ExamQuizStoreRequest;
use Module\ExamManagement\Requests\ExamQuizUpdateRequest;
use Module\ExamManagement\Service\QuizService;
use App\Traits\CheckPermission;

class ExamQuizController extends Controller
{
    public $quizService;
    use CheckPermission;

    public function __construct()
    {
        $this->quizService = new QuizService;
    }
    /*
    |--------------------------------------------------------------------------
    | INDEX METHOD
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("exam-quiz");

        $data['examQuizzes']    = ExamQuiz::query()
                                ->searchByField('exam_category_id')
                                ->searchByField('exam_id')
                                ->searchByField('chapter_id')
                                ->likeSearch('title')
                                ->with('exam', 'examCategory')
                                ->latest('id')
                                ->paginate(20);

        $data['table']          = ExamQuiz::getTableName();


        return view('exam-quiz/index',$data);
    }






    /*
    |--------------------------------------------------------------------------
    | CREATE METHOD
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("exam-quiz-create");

        $data['examCategory']   = ExamCategory::all();
        $data['exams']          = Exam::with('examCategory')->get();
        $data['examChapters']   = ExamChapter::with('exam')->get();
        $data['nextSerialNo']   = nextSerialNo(ExamQuiz::class);

        return view('exam-quiz/create', $data);
    }






    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(ExamQuizStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $this->quizService->storeQuiz($request);
                $this->quizService->updateOrCreateQuizOptions($request);
            });

            return redirect()->route('em.exam-quizzes.index')->withMessage('Exam Quiz has been created successfully!');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | EDIT METHOD
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("exam-quiz-edit");
        $data['examQuiz']            = ExamQuiz::where('id', $id)->with('quizOptions')->first();
        $data['exams']               = Exam::pluck('title', 'id');
        $data['examCategory']        = ExamCategory::pluck('name', 'id');
        $data['examChapters']        = ExamChapter::pluck('name', 'id');

        return view('exam-quiz.edit', $data);
    }







    /*
    |--------------------------------------------------------------------------
    | UPDATE METHOD
    |--------------------------------------------------------------------------
    */
    public function update(ExamQuizUpdateRequest $request, ExamQuiz $examQuiz)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $examQuiz) {
                $this->quizService->updateQuiz($request, $examQuiz);
                $this->quizService->updateOrCreateQuizOptions($request);
            });

            return redirect()->route('em.exam-quizzes.index')->withMessage('Exam has been updated successfully!');

        } catch (\Throwable $th) {
            return redirect()->route('em.exam-quizzes.index')->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | DESTROY METHOD
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $examQuiz = ExamQuiz::findOrFail($id);

            DB::transaction(function () use ($examQuiz) {
                $examQuiz->quizOptions()->delete();
                $examQuiz->delete();
            });

            return redirect()->route('em.exam-quizzes.index')->withMessage('Exam has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Exam');
        }
    }





    /*
    |--------------------------------------------------------------------------
    | FETCH EXAMS METHOD
    |--------------------------------------------------------------------------
    */
    public function fetchExams($exam_category_id)
    {
        return Exam::where('exam_category_id', $exam_category_id)->get(['id', 'title']);
    }





    /*
    |--------------------------------------------------------------------------
    | FETCH EXAM CHAPTERS METHOD
    |--------------------------------------------------------------------------
    */
    public function fetchExamChapters($exam_id)
    {
        return ExamChapter::where('exam_id', $exam_id)->get(['id', 'name']);
    }





    /*
    |--------------------------------------------------------------------------
    | DELETE QUIZ OPTION METHOD
    |--------------------------------------------------------------------------
    */
    public function deleteQuizOption($option_id)
    {
        try {
            QuizOption::destroy($option_id);
            return redirect()->back()->withMessage('Option has been deleted successfully!');
        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this option!');
        }
    }
}
