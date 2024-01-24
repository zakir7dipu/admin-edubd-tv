<?php

namespace Module\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\Requests\StudentStoreRequest;
use Module\CourseManagement\Requests\StudentUpdateRequest;
use Module\CourseManagement\Service\StudentService;
use App\Traits\CheckPermission;

class StudentController extends Controller
{

    use CheckPermission;

    use FileUploader;
    public $studentService;



    public function __construct()
    {
        $this->studentService = new StudentService;
    }




    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("student-view");

        $data['students']       = User::query()
                                        ->student()
                                        ->when(request('search'), function ($q) {
                                            $q->where(function ($q) {
                                                $q->where('first_name', 'like', '%' . request('search') . '%')
                                                ->orWhere('last_name', 'like', '%' . request('search') . '%')
                                                ->orWhere('username', 'like', '%' . request('search') . '%')
                                                ->orWhere('email', 'like', '%' . request('search') . '%')
                                                ->orWhere('phone', 'like', '%' . request('search') . '%')
                                                ->orWhere('bio', 'like', '%' . request('search') . '%');
                                            });
                                        })
                                        ->orderBy('id', 'DESC')
                                        ->paginate(20);
        $data['table']          = User::getTableName();

        return view('student/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("student-create");

        $data['countries'] = Country::pluck('name', 'id');
        return view('student/create', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(StudentStoreRequest $request)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request) {
                $this->studentService->updateOrCreateStudent($request);
                $this->studentService->storeStudentEducations($request);
            });

            return redirect()->route('cm.students.index')->withMessage('Student has been created successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.students.index')->withErrors($th->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("student-edit");

        $data['student']        = User::where('id', $id)->with('userEducations')->first();
        $data['countries']      = Country::pluck('name', 'id');

        return view('student/edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(StudentUpdateRequest $request, User $student)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $student) {
                $this->studentService->updateOrCreateStudent($request, $student->id);
                $this->studentService->storeStudentEducations($request);
            });

            return redirect()->route('cm.students.index')->withMessage('Students has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('cm.students.index')->withErrors($th->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | DESTROY/DELETE METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $student = User::find($id);

            DB::transaction(function () use ($student) {

                $student->userSkills()->delete();
                $student->userEducations()->delete();

                $image = $student->image;
                $student = $student->delete();

                if($student && file_exists($image)) {
                    unlink($image);
                }
            });

            return redirect()->route('cm.students.index')->withMessage('Student has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Student');
        }
    }
}
