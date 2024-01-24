<?php

namespace Module\ExamManagement\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\ExamManagement\Models\Institute;
use Module\ExamManagement\Requests\InstituteStoreRequest;
use Module\ExamManagement\Requests\InstituteUpdateRequest;
use App\Traits\CheckPermission;

class ExamInstituteController extends Controller
{
    use CheckPermission;

/*
|--------------------------------------------------------------------------
| INDEX METHOD
|--------------------------------------------------------------------------
*/


    public function index()
    {
        $this->hasAccess("exam-institute");

        $data['institutes']    = Institute::query()
                                            ->where('name', 'like', '%' . request('search') . '%')
                                            ->orWhere('short_form', 'like', '%' . request('search') . '%')
                                            ->orWhere('title', 'like', '%' . request('search') . '%')
                                            ->paginate(20);

        $data['table']         = Institute::getTableName();

        return view ('institute/index', $data);
    }






/*
|--------------------------------------------------------------------------
| CREATE METHOD
|--------------------------------------------------------------------------
*/


    public function create()
    {
        $this->hasAccess("exam-institute-create");

        return view('institute/create');
    }




/*
|--------------------------------------------------------------------------
| STORE METHOD
|--------------------------------------------------------------------------
*/
public function store(InstituteStoreRequest $request)
{
    try {
        $request->validated();

        DB::transaction(function () use ($request) {

            $institute = Institute::create([
                'name'               => $request->name,
                'short_form'         => $request->short_form,
                'title'              => $request->title,
                'address'            => $request->address,
                'website'            => $request->website,
                'status'             => $request->status ?? 0,
            ]);


        });

        return redirect()->route('em.institutes.index')->withMessage('Institue has been created successfully!');
    } catch (\Throwable $th) {

        return redirect()->route('em.institutes.index')->withErrors($th->getMessage());
    }
}





/*
|--------------------------------------------------------------------------
| EDIT METHOD
|--------------------------------------------------------------------------
*/
    public function edit($id)
    {
        $this->hasAccess("exam-institute-edit");

        $data['institute']            = Institute::find($id);
        return view('institute/edit', $data);
    }




/*
|--------------------------------------------------------------------------
| UPDATE METHOD
|--------------------------------------------------------------------------
*/
public function update(InstituteUpdateRequest $request, Institute $institute)
{
    try {
        $request->validated();

        $institute->update([
            'name'                   => $request->name,
            'short_form'             => $request->short_form,
            'title'                  => $request->title,
            'address'                => $request->address,
            'website'                => $request->website,
            'status'                 => $request->status ?? 0,
        ]);

        return redirect()->route('em.institutes.index')->withMessage('Institute has been updated successfully!');

    } catch (\Throwable $th) {

        return redirect()->route('em.institutes.index')->withErrors($th->getMessage());
    }
}


/*
|--------------------------------------------------------------------------
| DELETE METHOD
|--------------------------------------------------------------------------
*/

    public function destroy(Institute $institute)
    {
        try {

            $institute->delete();

            return redirect()->route('em.institutes.index')->withMessage('Institute has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Institute');
        }
    }
}
