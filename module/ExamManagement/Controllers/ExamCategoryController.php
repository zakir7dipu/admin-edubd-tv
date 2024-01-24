<?php

namespace Module\ExamManagement\Controllers;


use App\Http\Controllers\Controller;
use Module\ExamManagement\Models\ExamCategory;
use Module\ExamManagement\Requests\ExamCategoryStoreRequest;
use Module\ExamManagement\Requests\ExamCategoryUpdateRequest;
use App\Traits\CheckPermission;

class ExamCategoryController extends Controller
{
    use CheckPermission;

    /*
    |--------------------------------------------------------------------------
    | INDEX METHOD
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("exam-category");

        $data['examCategories'] = ExamCategory::query()
                                ->with('parentExamCategory:id,name')
                                ->withCount(['childExamCategories as totalChildExamCategories'])
                                ->searchByField('id')
                                ->searchByField('parent_id')
                                ->searchByField('name')
                                ->serialNoAsc()
                                ->paginate(20);

        $data['table']          = ExamCategory::getTableName();

        return view('exam-category/index', $data);
    }





    /*
    |--------------------------------------------------------------------------
    | CREATE METHOD
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("exam-category-create");

        $data['nextSerialNo'] = nextSerialNo(ExamCategory::class);

        return view('exam-category/create',$data);
    }





    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(ExamCategoryStoreRequest $request)
    {
        try {
            $request->validated();

            ExamCategory::create([
                'parent_id'         => $request->parent_id,
                'name'              => $request->name,
                'slug'              => $request->slug,
                'short_description' => $request->short_description,
                'serial_no'         => $request->serial_no,
                'show_in_menu'      => $request->show_in_menu ?? 0,
                'status'            => $request->status ?? 0,
            ]);

            return redirect()->route('em.exam-categories.index')->withMessage('Exam Category has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('em.exam-categories.index')->withErrors($th->getMessage());
        }
    }




    /*
    |--------------------------------------------------------------------------
    | EDIT METHOD
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("exam-category-edit");

        $data['examCategory'] = ExamCategory::find($id);

        return view('exam-category/edit', $data);
    }




    /*
    |--------------------------------------------------------------------------
    | UPDATE METHOD
    |--------------------------------------------------------------------------
    */
    public function update(ExamCategoryUpdateRequest $request, ExamCategory $examCategory)
    {
        try {
            $request->validated();

            $examCategory->update([
                'parent_id'         => $request->parent_id,
                'name'              => $request->name,
                'slug'              => $request->slug,
                'short_description' => $request->short_description,
                'serial_no'         => $request->serial_no,
                'show_in_menu'      => $request->show_in_menu ?? 0,
                'status'            => $request->status ?? 0,
            ]);

            return redirect()->route('em.exam-categories.index')->withMessage('Exam Category has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('em.exam-categories.index')->withErrors($th->getMessage());
        }
    }





    /*
    |--------------------------------------------------------------------------
    | DELETE METHOD
    |--------------------------------------------------------------------------
    */
    public function destroy(ExamCategory $examCategory)
    {
        try {

            $examCategory->delete();

            return redirect()->route('em.exam-categories.index')->withMessage('Exam Category has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Exam Category');
        }
    }
}
