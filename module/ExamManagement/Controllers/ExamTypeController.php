<?php

namespace Module\ExamManagement\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\ExamType;
use Module\ExamManagement\Requests\ExamTypeStoreRequest;
use Module\ExamManagement\Requests\ExamTypeUpdateRequest;
use App\Traits\CheckPermission;

class ExamTypeController extends Controller
{
    use CheckPermission;



/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/
    public function index()
    {
        $data['examTypes']           = ExamType::query()
                                                ->where('type', 'like', '%' . request('search') . '%')
                                                ->paginate(20);

        $data['table']           = ExamType::getTableName();


        return view('exam-type/index', $data);
    }





/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/
    public function create()
    {
        return view('exam-type/create');
    }





/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/
    public function store(ExamTypeStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {

                $examType = ExamType::create([
                    'type'                  => $request->type,
                    'slug'                  => $request->slug,
                    'status'                => $request->status ?? 0,
                ]);
            });

            return redirect()->route('em.exam-types.index')->withMessage('Exam Type has been created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('em.exam-types.index')->withErrors($th->getMessage());
        }
    }




    /*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/
    public function edit($id)
    {
        $data['examType']      = ExamType::find($id);
        return view('exam-type/edit', $data);
    }




    /*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
    public function update(ExamTypeUpdateRequest $request, ExamType $examType)
    {
        try {
            $request->validated();

            $examType->update([
                'type'              => $request->type,
                'slug'              => $request->slug,
                'status'            => $request->status ?? 0,
            ]);

            return redirect()->route('em.exam-types.index')->withMessage('Exam Type has been updated successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('em.exam-types.index')->withErrors($th->getMessage());
        }
    }



    /*
|--------------------------------------------------------------------------
| DELETE METHOD
|--------------------------------------------------------------------------
*/
    public function destroy(ExamType $examType)
    {
        try {

            $examType->delete();

            return redirect()->route('em.exam-types.index')->withMessage('Exam Type has been deleted successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Exam Type');
        }
    }
}
