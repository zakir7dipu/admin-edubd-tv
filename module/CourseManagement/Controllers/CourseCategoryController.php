<?php

namespace Module\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\Models\CourseCategory;
use Module\CourseManagement\Requests\CourseCategoryStoreRequest;
use Module\CourseManagement\Requests\CourseCategoryUpdateRequest;
use App\Traits\CheckPermission;

class CourseCategoryController extends Controller
{
    use FileUploader;
    use CheckPermission;





    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("course-category-view");

        $data['courseCategories']   = CourseCategory::query()
                                    ->with('parentCourseCategory:id,name')
                                    ->withCount(['childCourseCategories as totalChildCourseCategories'])
                                    ->searchByField('id')
                                    ->searchByField('parent_id')
                                    ->searchByField('name')
                                    ->idDesc()
                                    ->paginate(20);

        $data['table']              = CourseCategory::getTableName();

        return view('course-category/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("course-category-create");

        $data['nextSerialNo'] = nextSerialNo(CourseCategory::class);

        return view('course-category/create', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(CourseCategoryStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $courseCategory = CourseCategory::create([
                    'parent_id'         => $request->parent_id,
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'short_description' => $request->short_description,
                    'serial_no'         => $request->serial_no,
                    'icon'              => 'default.png',
                    'is_highlighted'    => $request->is_highlighted ?? 0,
                    'show_in_menu'      => $request->show_in_menu ?? 0,
                    'status'            => $request->status ?? 0,
                ]);

                $this->uploadImage($request->icon, $courseCategory, 'icon', 'course-category/icon', 250, 250);
            });

            return redirect()->route('cm.course-categories.index')->withMessage('Course Category has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.course-categories.index')->withErrors($th->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("course-category-edit");

        $data['courseCategory'] = CourseCategory::find($id);

        return view('course-category/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(CourseCategoryUpdateRequest $request, CourseCategory $courseCategory)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($courseCategory, $request) {
                $courseCategory->update([
                    'parent_id'         => $request->parent_id,
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'short_description' => $request->short_description,
                    'serial_no'         => $request->serial_no,
                    'icon'              => $courseCategory->icon,
                    'is_highlighted'    => $request->is_highlighted ?? 0,
                    'show_in_menu'      => $request->show_in_menu ?? 0,
                    'status'            => $request->status ?? 0,
                ]);

                $this->uploadImage($request->icon, $courseCategory, 'icon', 'course-category/icon', 250, 250);
            });

            return redirect()->route('cm.course-categories.index')->withMessage('Course Category has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.course-categories.index')->withErrors($th->getMessage());
        }
    }

    



    /*
    |--------------------------------------------------------------------------
    | DESTROY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function destroy(CourseCategory $courseCategory)
    {
        try {
            
            DB::transaction(function () use ($courseCategory) {

                $icon = $courseCategory->icon;
                $courseCategory->delete();

                if($courseCategory && file_exists($icon)) {
                    unlink($icon);
                }
            });

            return redirect()->route('cm.course-categories.index')->withMessage('Course Category has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Course Category');
        }
    }
}