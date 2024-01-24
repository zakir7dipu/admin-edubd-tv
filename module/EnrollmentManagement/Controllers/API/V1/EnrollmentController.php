<?php

namespace Module\EnrollmentManagement\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Jobs\EnrollmentSuccessfullyJob;
use Illuminate\Support\Facades\DB;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Requests\EnrollmentStoreRequest;
use Module\EnrollmentManagement\Requests\OrderStoreRequest;
use Illuminate\Http\Request;
use Module\EnrollmentManagement\Service\EnrollmentService;
use Module\EnrollmentManagement\Service\OrderService;
use Module\EnrollmentManagement\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public $enrollment;
    public $enrollmentService;





    public function __construct()
    {
        $this->enrollmentService = new EnrollmentService;
    }





    /*
    |--------------------------------------------------------------------------
    | INDEX (METHOD)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        try {
            $enrollments    = Enrollment::query()
                ->authorize()
                ->when(request()->filled('search'), function ($q) {
                    $q->where(function ($q) {
                        $q->where('invoice_no', 'LIKE', '%' . request('search') . '%')
                            ->orWhere('date', 'LIKE', '%' . request('search') . '%');
                    })
                        ->orWhereHas('student', function ($q) {
                            $q->where('first_name', 'LIKE', '%' . request('search') . '%')
                                ->orWhere('last_name', 'LIKE', '%' . request('search') . '%')
                                ->orWhere('username', 'LIKE', '%' . request('search') . '%');
                        });
                })
                ->where('payment_status','Paid')
                ->with('student:id,first_name,last_name,username,image')
                ->with('enrollmentItems.course')
                ->with('course')
                ->orderBy('id', 'DESC')
                ->paginate(20);

            return  response()->json([
                'status'    => 1,
                'message'   => count($enrollments) > 0 ? 'Success' : 'No enrollments found!',
                'data'      => $enrollments,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | STORE (METHOD)
    |--------------------------------------------------------------------------
    */
    public function store(EnrollmentStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->enrollment = $this->enrollmentService->storeEnrollment($request);
                // dd( $this->enrollment);
                $this->enrollmentService->storeEnrollmentItems($request);

            if($request->coupon_id != null && $request->payment_status == 'Paid'){
                $this->enrollment->couponUses()->updateOrCreate([
                    'coupon_id' =>$request->coupon_id,
                    'student_id' => Auth::id()
                ]);
            }
               

            });

            return  response()->json([
                'status'    => 1,
                'message'   => 'Course Enrollment Successfully',
                'data'      => encrypt(optional($this->enrollment)->invoice_no),
                'enrollData' => $this->enrollment,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | SHOW (METHOD)
    |--------------------------------------------------------------------------
    */
    public function show($invoice_no)
    {
        try {
            $enrollment = Enrollment::query()
                ->where('invoice_no', $invoice_no)
                ->where('payment_status','Paid')
                ->with('student')
                ->with('paymentMethod')
                ->with('enrollmentItems.course')
                ->first();

            return  response()->json([
                'status'    => 1,
                'message'   => 'Success!',
                'data'      => $enrollment,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE (METHOD)
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        try {
            $enrollment = Enrollment::find($id);
            $invoice_number = encrypt($enrollment->invoice_no);
            DB::transaction(function () use ($request, $enrollment) {

                $enrollment->update([
                    'payment_status'                 => $request->payment_status,

                ]);
                if($enrollment->coupon_id != null && $enrollment->payment_status == 'Paid'){
                    $enrollment->couponUses()->updateOrCreate([
                        'coupon_id' =>$enrollment->coupon_id,
                        'student_id' => $enrollment->student_id
                    ]);
                }

            });

            return  response()->json([
                'status'    => 1,
                'message'   => 'Course Enrollment update Successfully',
                'data'      => $invoice_number,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }


    // update for apps
    public function updateApp($id)
    {
        try {
            $enrollment = Enrollment::find($id);
            DB::transaction(function () use ($enrollment) {

                $enrollment->update([
                    'payment_status'                 => "Paid",

                ]);
                if($enrollment->coupon_id != null && $enrollment->payment_status == 'Paid'){
                    $enrollment->couponUses()->updateOrCreate([
                        'coupon_id' =>$enrollment->coupon_id,
                        'student_id' => $enrollment->student_id
                    ]);
                }

            });

            return  response()->json([
                'status'    => 1,
                'message'   => 'Course Enrollment update Successfully',
                'data'      => $enrollment,
                'errors'    => null
            ]);
        } catch (\Throwable $th) {
            return  response()
                ->json([
                    'status'    => 0,
                    'message'   => 'There was an error!',
                    'data'      => '',
                    'error'     => $th->getMessage()
                ]);
        }
    }
}
