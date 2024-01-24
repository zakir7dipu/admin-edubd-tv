<?php

namespace Module\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\Requests\InstructorStoreRequest;
use Module\CourseManagement\Requests\InstructorUpdateRequest;
use Module\CourseManagement\Service\InstructorService;
use App\Traits\CheckPermission;

class InstructorController extends Controller
{
    use FileUploader;
    public $instructorService;
    use CheckPermission;





    public function __construct()
    {
        $this->instructorService = new InstructorService;
    }






    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("instructor-view");

        $data['instructors']    = User::query()
                                ->instructor()
                                ->when(request('search'), function ($q) {
                                    $q->where(function ($q) {
                                        $q->where('first_name', 'like', '%' . request('search') . '%')
                                        ->orWhere('last_name', 'like', '%' . request('search') . '%')
                                        ->orWhere('username', 'like', '%' . request('search') . '%')
                                        ->orWhere('email', 'like', '%' . request('search') . '%')
                                        ->orWhere('phone', 'like', '%' . request('search') . '%')
                                        ->orWhere('gender', 'like', '%' . request('search') . '%');
                                    });
                                })
                                ->orderBy('id', 'DESC')
                                ->paginate(20);

        $data['table']          = User::getTableName();

        return view('instructor/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("instructor-create");

        $data['countries'] = Country::pluck('name', 'id');

        return view('instructor/create', $data);
    }





   /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(InstructorStoreRequest $request)
    {
        try {
            $request->validated();
// dd($request->all());
            DB::transaction(function () use ($request) {
                $this->instructorService->updateOrCreateInstructor($request);
                $this->instructorService->storeInstructorSkills($request);
                $this->instructorService->storeInstructorEducations($request);
                $this->instructorService->storeInstructorSocialLink($request);
            });

            return redirect()->route('cm.instructors.index')->withMessage('Instructor has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.instructors.index')->withErrors($th->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | SHOW METHOD
     |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        //
    }





    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("instructor-edit");

        $data['instructor'] = User::where('id', $id)->with('userSkills:user_id,name', 'userEducations')->first();
        $data['countries']  = Country::pluck('name', 'id');

        return view('instructor/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(InstructorUpdateRequest $request, User $instructor)
    {
        try {
            $request->validated();
// dd($request->all());
            DB::transaction(function () use ($request, $instructor) {
                $this->instructorService->updateOrCreateInstructor($request, $instructor->id);
                $this->instructorService->storeInstructorSkills($request);
                $this->instructorService->storeInstructorEducations($request);
                $this->instructorService->storeInstructorSocialLink($request);
            });

            return redirect()->route('cm.instructors.index')->withMessage('Instructor has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.instructors.index')->withErrors($th->getMessage());
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
            $instructor = User::find($id);

            DB::transaction(function () use ($instructor) {

                $instructor->userSkills()->delete();
                $instructor->userEducations()->delete();

                $image = $instructor->image;
                $instructor = $instructor->delete();

                if($instructor && file_exists($image)) {
                    unlink($image);
                }
            });

            return redirect()->route('cm.instructors.index')->withMessage('Instructor has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Instructors');
        }
    }
}
