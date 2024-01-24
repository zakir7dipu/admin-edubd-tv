<?php

namespace Module\ExamManagement\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\ExamManagement\Models\Exam;
use Module\ExamManagement\Models\ExamCategory;
use Module\ExamManagement\Models\ExamChapter;
use Module\ExamManagement\Models\ExamQuiz;
use Module\ExamManagement\Models\ExamType;
use Module\ExamManagement\Models\ExamYear;
use Module\ExamManagement\Resources\ExamChapterResource;
use Module\ExamManagement\Resources\ExamQuizResource;
use Module\ExamManagement\Resources\ExamResource;
use Module\ExamManagement\Resources\ExamsTypeResource;
use Module\ExamManagement\Resources\ExamsYearResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\QuizTest;
use Module\ExamManagement\Models\QuizTestQuizzes;
use Module\ExamManagement\Service\ExamService;

class ExamController extends Controller
{

    public $examService;
    public $quizTest;
    public $quizUpdate;
    public $quizTestQuizzes;

    public function __construct()
    {
        $this->examService = new ExamService;
    }

    /*
     |--------------------------------------------------------------------------
     |  EXAMS  (METHOD)
     |--------------------------------------------------------------------------
    */
    public function exams()
    {
        try {

            $category_ids   = ExamCategory::query()
                ->when(request()->filled('category_slug'), function ($q) {
                    $q->whereIn('slug', request('category_slug'));
                })
                ->pluck('id');

            $year_ids       = ExamYear::query()
                ->when(request()->filled('exam_year'), function ($q) {
                    $q->whereIn('year', request('exam_year'));
                })
                ->pluck('id');

            $exams          = ExamResource::collection(
                Exam::query()
                    ->active()
                    ->when(request()->filled('category_slug'), fn ($q) => $q->whereIn('exam_category_id', $category_ids))
                    ->when(request()->filled('exam_year'), fn ($q) => $q->whereIn('exam_year_id', $year_ids))
                    ->when(request()->filled('fee_type'), function ($q) {
                        if (in_array("Free", request('fee_type')) && in_array("Paid", request('fee_type'))) {
                            $q->where('exam_fee', '>=', 0);
                        } elseif (in_array("Free", request('fee_type'))) {
                            $q->freeExam();
                        } elseif (in_array("Paid", request('fee_type'))) {
                            $q->paidExam();
                        }
                    })
                    ->paginate(12)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($exams) == 0 ? 'No items found!' : 'Success!',
                'data'      => $exams,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     |  EXAM YEARS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function examYears()
    {
        try {
            $examYears  = ExamsYearResource::collection(
                ExamYear::query()->active()->get()
            )
                ->response()
                ->getData(true);

            return response()->json([
                'status'    => 1,
                'message'   => count($examYears) == 0 ? 'No items found!' : 'Success!',
                'data'      => $examYears,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     |  EXAM TYPES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function examTypes()
    {
        try {
            $examTypes = ExamsTypeResource::collection(
                ExamType::query()->active()->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($examTypes) == 0 ? 'No items found!' : 'Success!',
                'data'      => $examTypes,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | EXAMS BY CATEGORY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function examsByCategory($category_id)
    {
        try {
            $exams    = ExamResource::collection(
                Exam::query()
                    ->when(request('exam_category_id'), function ($q) use ($category_id) {
                        $q->whereIn('exam_category_id', $category_id);
                    })

                    ->idDesc()
                    ->paginate(8)
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($exams) == 0 ? 'No items found!' : 'Success!',
                'data'      => $exams,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM DETAILS (METHOD)
    |--------------------------------------------------------------------------
    */
    public function examDetails($slug)
    {
        try {
            $exam   = Exam::query()
                ->active()
                ->where('slug', $slug)
                ->with('examCategory:id,name')
                ->with('institute:id,short_form')
                ->with('examYear:id,year')
                ->with(['examChapters' => function ($q) {
                    $q->examChapterPublishedActive()
                        ->whereHas('examQuizzes', fn ($q) => $q->quizActive())
                        ->withCount(['examQuizzes as totalChapterQuiz' => fn ($q) => $q->quizActive()])
                        ->having('totalChapterQuiz', '>', 0);
                }])
                ->with('examQuizzes')
                ->withCount(['examQuizzes as totalExamQuiz' => function ($q) {
                    $q->active()
                        ->whereHas('examChapters', function ($q) {
                            $q->publishedActive()
                                ->whereHas('examQuizzes', fn ($q) => $q->active())
                                ->withCount(['examQuizzes as totalChapterQuiz' => fn ($q) => $q->active()])
                                ->having('totalChapterQuiz', '>', 0);
                        });
                }])
                ->first();

            return  response()->json([
                'status'    => 1,
                'message'   => 'Success!',
                'data'      => $exam,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }




    public function chapterByExam($slug)
    {
        try {

            $exams_id              = optional(Exam::where('slug', $slug)->first())->id;
            $chapters              = ExamChapterResource::collection(
                ExamChapter::query()
                    ->where('exam_id', $exams_id)
                    ->with('examQuiz')
                    ->get()
            )
                ->response()
                ->getData(true);

            return  response()->json([
                'status'    => 1,
                'message'   => count($chapters) > 0 ? 'Success' : 'No Chapter found!',
                'data'      => $chapters,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }


    public function quizzesBychapterShow($chapterSlug)
    {
        try {

            $chapter_id            = optional(ExamChapter::where('slug', $chapterSlug)->first())->id;
            $quizzes               = ExamQuizResource::collection(
                ExamQuiz::query()
                    ->where('chapter_id', $chapter_id)
                    ->with('quizOptions')
                    // ->with('examChapters')
                    ->paginate(1)
            )
                ->response()
                ->getData(true);
            // dd($quizzes);
            return  response()->json([
                'status'    => 1,
                'message'   => count($quizzes) > 0 ? 'Success' : 'No Chapter found!',
                'data'      => $quizzes,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }




    public function ExamQuizTest(Request $request)
    {
        try {
            $request->validate([
                // 'name' => 'required|max:255',
                // 'email' => 'required|email|unique:users,email',
                // 'password' => 'required|min:8',
            ]);


            DB::transaction(function () use ($request) {
                $this->quizTest             = QuizTest::create([
                    'student_id'            => auth()->id(),
                    'chapter_id'            => $request->chapter_id,
                    'total_quiz'            => $request->total_quiz,
                ]);

                $quizze = $request->quizzes;
                foreach ($quizze as $key => $quiz) {
                    $this->quizTest->quizTestQuizzes()->create([
                        'quiz_id'               =>  $quiz['id'],
                    ]);
                }
            });


            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'quiz test create successfully !',
                    'user'          => $this->quizTest,

                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,

                ]);
        }
    }



    public function getQuizTest($id)
    {
        try {
            $quizTest   = QuizTest::query()
                ->where('id', $id)
                ->withCount('quizTestQuizzes as TotalQuiz')
                ->with(['quizTestQuizzes' => function ($q) {
                    $q->having('mark', '>', 0);
                }])

                ->get();

            return  response()->json([
                'status'    => 1,
                'message'   => 'Success!',
                'data'      => $quizTest,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => null,
                    'error'     => $th->getMessage()
                ]);
        }
    }



    public function GetExamQuizTestQuizzes($quizTestId)
    { {
            try {

                $quizTestQuizzes = QuizTestQuizzes::where('quiz_test_id', $quizTestId)
                    ->with('quiz')
                    ->paginate(1);

                // ->getData(true);
                // dd($quizzes);
                return  response()->json([
                    'status'    => 1,
                    'message'   => count($quizTestQuizzes) > 0 ? 'Success' : 'No QuizTestQuizez found!',
                    'data'      => $quizTestQuizzes,
                    'errors'    => null
                ]);
            } catch (\Throwable $th) {
                return  response()
                    ->json([
                        'status'    => 0,
                        'message'   => 'There was an error!',
                        'data'      => null,
                        'error'     => $th->getMessage()
                    ]);
            }
        }
    }



    public function ExamQuizTestQuizzes(Request $request, $quizTestId, $quizzesId)
    {
        try {
            $request->validate([
                // 'name' => 'required|max:255',
                // 'email' => 'required|email|unique:users,email',
                // 'password' => 'required|min:8',
            ]);



            DB::transaction(function () use ($request, $quizTestId, $quizzesId) {

                $this->quizUpdate = QuizTest::find($quizTestId);
                $previousMark = $this->quizUpdate->total_marks;
                $currentMark = $previousMark + $request->totalMarks;


                $this->quizUpdate->update([
                    'total_marks'           => $currentMark,
                    'is_completed'          => $request->is_completed
                ]);


                $quiztestQuiz = QuizTestQuizzes::find($quizzesId);

                $quiztestQuiz->update([
                    'mark' => $request->mark
                ]);
            });

            return response()
                ->json([
                    'status'        => 1,
                    'message'       => 'quiz test updated successfully !',
                    'user'          => $this->quizUpdate,

                ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'        => 0,
                    'message'       => $th->getMessage(),
                    'user'          => null,

                ]);
        }
    }
}
