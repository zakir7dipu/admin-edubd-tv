<?php

namespace Module\CourseManagement\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use App\Traits\FileUploader;
use App\Traits\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Module\CourseManagement\Models\Course;
use Module\CourseManagement\Models\CourseFAQ;
use Module\CourseManagement\Models\CourseLevel;
use Module\CourseManagement\Models\CourseTopic;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\CourseOutcome;
use Module\CourseManagement\Models\CourseLanguage;
use Module\CourseManagement\Service\CourseService;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Module\CourseManagement\Models\CourseInstructor;
use Module\CourseManagement\Service\CategoryService;
use Module\CourseManagement\Models\CourseIntroduction;
use Module\CourseManagement\Models\LessonQuiz;
use Module\CourseManagement\Requests\CourseStoreRequest;
use Module\CourseManagement\Requests\CourseUpdateRequest;
use Module\CourseManagement\Service\LessonQuizService;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class CourseLessonQuizController extends Controller
{
    use FileUploader;

    public $course;
    public $lessonQuizService;

    use CheckPermission;




    public function __construct()
    {
        $this->lessonQuizService = new LessonQuizService;
    }





    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("lesson-quiz-view");

        $lesson_id              = optional(CourseLesson::where('is_quiz',1)->pluck('id'));
        // dd($lesson_id);

        // $data['courseLevels']       = CourseLevel::pluck('name', 'id');
        // $data['courseLanguages']    = CourseLanguage::pluck('name', 'id');
        $data['course_lessons'] = CourseLesson::where('is_quiz', 1)->pluck('title', 'id');
        $data['lesson_quiz']            = LessonQuiz::query()
            ->searchByField('lesson_id')
            ->idDesc()
            ->paginate(20);

        $data['table']              = LessonQuiz::getTableName();

        // return view('course/index', $data);
        return view('lesson-quiz/index',$data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {


       $data['course_lessons'] = CourseLesson::where('is_quiz', 1)->pluck('title', 'id');

        return view('lesson-quiz.create',$data);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // $request->validated();

            DB::transaction(function () use ($request) {
                $this->lessonQuizService->storeLessonQuiz($request);
                $this->lessonQuizService->updateOrCreateLessonQuizOptions($request);
            });

            return redirect()->route('cm.lesson-quiz.index')->withMessage('Lesson Quiz has been created successfully!');
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
        $data['course_lessons'] = CourseLesson::where('is_quiz', 1)->pluck('title', 'id');
        $data['lesson_quiz']           =LessonQuiz::find($id);

        return view('lesson-quiz/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, LessonQuiz $lesson_quiz)
    {
        try {


            DB::transaction(function () use ($lesson_quiz, $request) {
                $this->lessonQuizService->updateLessonQuiz($request, $lesson_quiz);
                $this->lessonQuizService->updateOrCreateLessonQuizOptions($request);
            });

            return redirect()->route('cm.lesson-quiz.index')->withMessage('Lesson Quiz has been updated successfully!');;
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors($th->getMessage());
        }
    }











    /*
     |--------------------------------------------------------------------------
     | DESTROY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $lesson_quiz = LessonQuiz::findOrFail($id);

            DB::transaction(function () use ($lesson_quiz) {
                $lesson_quiz->lessonQuizOption()->delete();
                $lesson_quiz->delete();
            });

            return redirect()->route('cm.lesson-quiz.index')->withMessage('lesson quiz has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this lesson quiz');
        }
    }

}
