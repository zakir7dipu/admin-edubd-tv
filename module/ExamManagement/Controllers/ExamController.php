<?php

namespace Module\ExamManagement\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\Exam;
use Module\ExamManagement\Models\ExamCategory;
use Module\ExamManagement\Models\ExamChapter;
use Module\ExamManagement\Models\ExamType;
use Module\ExamManagement\Models\ExamYear;
use Module\ExamManagement\Models\Institute;
use Module\ExamManagement\Requests\ExamStoreRequest;
use Module\ExamManagement\Requests\ExamUpdateRequest;
use Module\ExamManagement\Service\ExamService;
use App\Traits\CheckPermission;

class ExamController extends Controller
{
    public $examService;
    use CheckPermission;

    public function __construct()
    {
        $this->examService = new ExamService;
    }



/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/

    public function index()
    {
        $this->hasAccess("exam-view");

        $data['exams']                     = Exam::query()
                                                  ->searchByField('id')
                                                  ->searchByField('examCategory')
                                                  ->searchByField('name')
                                                  ->with('examCategory','examType','examYear','institute')
                                                  ->paginate(20);
        $data['exam_categories']           = ExamCategory::pluck('name', 'id');
        $data['table']                     = Exam::getTableName();


        return view('exam/index',$data);
    }






/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/
    public function create()
    {
        $this->hasAccess("exam-create");

        $data['examCategories']           = ExamCategory::pluck('name', 'id');
        $data['examTypes']                = ExamType::pluck('type', 'id');
        $data['examYears']                = ExamYear::pluck('year','id');
        $data['institutes']               = Institute::select('id','name','short_form')->get();
        $data['nextSerialNo']             = nextSerialNo(Exam::class);

        return view('exam/create', $data);
    }








    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(ExamStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $this->examService->updateOrCreateExam($request);
                $this->examService->storeExamChapter($request);
            });

            return redirect()->route('em.exams.index')->withMessage('Exam has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('em.exams.index')->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | EDIT METHOD
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("exam-edit");

        $data['exam']                  = Exam::where('id', $id)->with('examChapters')->first();
        $data['examCategory']          = ExamCategory::pluck('name', 'id');
        $data['examType']              = ExamType::pluck('type', 'id');
        $data['examYear']              = ExamYear::pluck('year', 'id');
        $data['institute']             = Institute::select('id','name','short_form')->get();


        return view('exam/edit',$data);
    }


/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
public function update(ExamUpdateRequest $request, Exam $exam)
{
    try {
        $request->validated();
        DB::transaction(function () use ($request, $exam) {
            $this->examService->updateOrCreateExam($request, $exam->id);
            $this->examService->storeExamChapter($request);
        });

        return redirect()->route('em.exams.index')->withMessage('Exam has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('em.exams.index')->withErrors($th->getMessage());
    }
}




/*
|--------------------------------------------------------------------------
| DELETE METHOD
|--------------------------------------------------------------------------
*/
public function destroy($id)
{
    try {
        $exam = Exam::find($id);

        DB::transaction(function () use ($exam) {


            $exam->examChapter()->delete();
            $exam->delete();


        });

        return redirect()->route('em.exams.index')->withMessage('Exam has been deleted successfully!');

    } catch(\Exception $ex) {
        return redirect()->back()->withWarning('You can not delete this Exam');
    }
}


   /*
    |--------------------------------------------------------------------------
    | DELETE QUIZ OPTION METHOD
    |--------------------------------------------------------------------------
    */
    public function deleteExamChapter($chapter_id)
    {
        try {
            ExamChapter::destroy($chapter_id);
            return redirect()->back()->withMessage('Chapter has been deleted successfully!');
        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this option!');
        }
    }


}
