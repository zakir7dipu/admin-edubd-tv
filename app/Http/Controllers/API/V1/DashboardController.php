<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Models\EnrollmentItem;

class DashboardController extends Controller
{
    public function __invoke()
    {
        try {

            $data['myCourseCount']          = EnrollmentItem::query()
            ->whereHas('enrollment', fn ($q) => $q->where('student_id', auth()->id())
                                                ->where('payment_status', '=', 'Paid'))
            // ->groupBy('course_id')
            ->count();
            $data['courseEnrollmentCount']  = Enrollment::authorize()->where('payment_status', '=', 'Paid')->count();
            // $data['myCourseCount']          = EnrollmentItem::whereHas('enrollment', fn ($q) => $q->authorize())->groupBy('course_id')->count();
            // $data['courseEnrollmentCount']  = Enrollment::authorize()->count();

            return response()->json([
                'status'    => 1,
                'message'   => 'Success',
                'data'      => $data,
                'error'     => null
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 1,
                'message'   => 'Something went wrong!',
                'data'      => [],
                'error'     => $th->getMessage()
            ]);
        }
    }
}
