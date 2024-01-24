<?php

namespace Module\ExamManagement\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\ExamYear;
use Module\ExamManagement\Requests\ExamTypeStoreRequest;
use Module\ExamManagement\Requests\ExamYearStoreRequest;
use Module\ExamManagement\Requests\ExamYearUpdateRequest;
use App\Traits\CheckPermission;

class ExamYearController extends Controller
{
    use CheckPermission;

/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/


    public function index()
    {
        $this->hasAccess("exam-year");

        $data['examYears']           = ExamYear::query()
                                                 ->where('year', 'like', '%' . request('search') . '%')
                                                 ->paginate(20);

        $data['table']               = ExamYear::getTableName();


        return view('exam-year/index', $data);
    }



    /*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/
    public function create()
    {
        $this->hasAccess("exam-year-create");

        return view('exam-year/create');
    }


    /*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/


public function store(ExamYearStoreRequest $request)
{
    try {
        $request->validated();

        DB::transaction(function () use ($request) {

            $examYear = ExamYear::create([
                'year'                 => $request->year,
                'status'                => $request->status ?? 0,
            ]);


        });

        return redirect()->route('em.exam-years.index')->withMessage('Exam Year has been created successfully!');
    } catch (\Throwable $th) {

        return redirect()->route('em.exam-years.index')->withErrors($th->getMessage());
    }
}



    /*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/

    public function edit($id)
    {
        $this->hasAccess("exam-year-edit");

        $data['examYear'] = ExamYear::find($id);
        return view ('exam-year/edit', $data);
    }



    /*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
public function update(ExamYearUpdateRequest $request, ExamYear $examYear)
{
    try {
        $request->validated();

        $examYear->update([
            'year'              => $request->year,
            'slug'              => $request->slug,
            'status'            => $request->status ?? 0,
        ]);

        return redirect()->route('em.exam-years.index')->withMessage('Exam Year has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('em.exam-years.index')->withErrors($th->getMessage());
    }
}


/*
|--------------------------------------------------------------------------
| DELETE METHOD
|--------------------------------------------------------------------------
*/
public function destroy(ExamYear $examYear)
{
    try {

        $examYear->delete();

        return redirect()->route('em.exam-years.index')->withMessage('Exam Year has been deleted successfully!');

    } catch(\Exception $ex) {
        return redirect()->back()->withWarning('You can not delete this Exam Year');
    }
}
}
