<?php

namespace Module\EnrollmentManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Models\EnrollmentItem;
use Module\CourseManagement\Models\Course;
use Carbon\Carbon;
use App\Traits\CheckPermission;


class DailyReportController extends Controller
{
    use CheckPermission;

    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("todat-sales");

        $today = Carbon::today()->toDateString();
        $data['enrolls']           = EnrollmentItem::query()
        ->with( 'course')
        ->searchByField('course_id')
        ->searchByField('enrollment_id')
        ->whereDate('created_at',   $today)
        ->paginate(20);
        
        $data['enrollmentPayment']  = Enrollment::pluck('payment_method', 'id');
        $data['enrollment']         = Enrollment::pluck('invoice_no', 'id');
        $data['course']             = Course::pluck('title', 'id');
        $data['table']              = EnrollmentItem::getTableName();



        return view('report/index', $data);
    }








  
}
