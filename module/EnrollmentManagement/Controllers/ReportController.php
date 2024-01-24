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
use Module\EnrollmentManagement\Services\ReportService;
use App\Services\ExportService;
use PDF;
use App\Traits\CheckPermission;



class ReportController extends Controller
{
    private $export_service;
    use CheckPermission;

    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */  
    public function __construct(Request $request)
    {
        $this->export_service   = new ExportService();
    }


    public function index(Request $request)
    {
        $this->hasAccess("sales-report");

        $startDate = $request->start_date ?? date('Y-m-d');
        $endDate = $request->end_date ?? date('Y-m-d');

        $data['enrolls'] = EnrollmentItem::query()
            ->with('course:id,title', 'enrollment.student:id,first_name')
            ->select('*', DB::raw("DATE(created_at) as created_date"))
            ->searchByField('course_id')
            ->searchByField('enrollment_id:id,invoice_no')
            ->searchByField('enrollment_id')
            ->when($request->filled('start_date'), function($q) use($startDate, $endDate) {
                $endDateWithTime = $endDate . ' 23:59:59';
                $q->whereBetween('created_at', [$startDate, $endDateWithTime]);
            })->orderByDesc('created_at');

            if(request('export_type')){
                $data['enrolls']=$data['enrolls']->get();
                return $this->export_service->exportData($data, 'report-all/export/', 'Report List');
            }
            if(request('pdf_type')){
                $data['enrolls']=$data['enrolls']->get();
                $pdf = PDF::loadView('report-all/export/pdf', $data);

                return $pdf->download('report-all.pdf');
              }
            // dd($data['enrolls']);
    
        $data['enrollment'] = Enrollment::pluck('invoice_no', 'id');
        $data['courses'] = Course::pluck('title', 'id');
        $data['table'] = EnrollmentItem::getTableName();

        $data['enrolls'] = $data['enrolls']->paginate(20);
    // dd($request->created_at);
        return view('report-all/index', $data);
    }
    








  
}
