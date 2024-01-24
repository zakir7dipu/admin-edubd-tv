<?php

namespace Module\CourseManagement\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Module\CourseManagement\Requests\InstructorStoreRequest;
use Module\CourseManagement\Service\InstructorService;

class InstructorApiController extends Controller
{
    public $instructor;
    use FileUploader;
    public $instructorService;





    public function __construct()
    {
        $this->instructorService = new InstructorService;
    }




    /*
    |--------------------------------------------------------------------------
    | Instructor show (METHOD)
    |--------------------------------------------------------------------------
    */

    public function ShowInstructors($userName)
    {
        try {
            $instructor     = User::query()
                ->instructor()
                ->where('username', $userName)
                ->with('userPrimaryEducation', 'userSkills', 'courseInstructors.course.category','userSocialLink')
                ->first();

            return  response()->json([
                'status'    => 1,
                'message'   => $instructor ? 'Success' : 'Not Found!',
                'data'      => $instructor,
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
    | REGISTER (METHOD)
    |--------------------------------------------------------------------------
    */
    public function CreateInstructor(InstructorStoreRequest $request)
    {
        try {
            $request->validated($request->all());

            DB::transaction(function () use ($request) {
                $this->instructorService->updateOrCreateInstructor($request);
                $this->instructorService->storeInstructorSkills($request);
                $this->instructorService->storeInstructorEducations($request);
            });
            // email data
            // $email_data = array(
            //     'name' => $request->username,
            //     'email' => $request->email,
            // );
            // Mail::send('welcome-mail.wellcome', $email_data, function ($message) use ($email_data) {
            //     $message->to($email_data['email'], $email_data['name'])
            //         ->subject('Welcome to MyNotePaper')
            //         ->from('info@mynotepaper.com', 'MyNotePaper');
            // });

            return  response()
                ->json([
                    'status'        => 1,
                    'message'       => 'Instructor has been create successfully !',
                    'user'          => $this->instructorService,

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


    /*
    |--------------------------------------------------------------------------
    | Show All Instructor (METHOD)
    |--------------------------------------------------------------------------
    */

    public function ShowInstructorsAll()
    {
        try {
            $instructor     = User::query()
            ->instructor()
                ->where('status', 1)
                ->with('userSocialLink')
                ->paginate(8);


            return  response()->json([
                'status'    => 1,
                'message'   => $instructor ? 'Success' : 'Not Found!',
                'data'      => $instructor,
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
