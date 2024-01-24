<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\SiteInfo;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\CourseManagement\Models\Course;

use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index()
     {
         $today = Carbon::today()->toDateString();
         
         $data['todaySales'] = Enrollment::where('payment_status', '=', 'Paid')->whereDate('created_at', $today)
             ->sum('grand_total');
     
         $data['todayOrder'] = Enrollment::where('payment_status', '=', 'Paid')->whereDate('created_at', $today)
             ->count();
     
         $data['thisMonthSales'] = Enrollment::where('payment_status', '=', 'Paid')->whereMonth('created_at', Carbon::now()->month)
             ->sum('grand_total');
     
         $data['monthOrder'] = Enrollment::where('payment_status', '=', 'Paid')->whereMonth('created_at', Carbon::now()->month)
             ->count();
     
         $data['courseCount'] = Course::count();
     
         $firstDay = Carbon::now()->startOfMonth();
         $lastDay = Carbon::now()->endOfMonth();
     
         // Retrieve the daily sales data for the current month
         $monthlySalesData = Enrollment::whereBetween('created_at', [$firstDay, $lastDay])
             ->selectRaw('DATE(created_at) as day, SUM(grand_total) as total')
             ->groupBy('day')
             ->pluck('total', 'day')
             ->toArray();
     
         // Prepare the data for the line chart
         $labels = [];
         $chartData = [];
     
         // Iterate through each day of the current month and populate the labels and data arrays
         for ($date = $firstDay; $date <= $lastDay; $date->addDay()) {
             $day = $date->toDateString();
             $labels[] = $date->format('d');
             $chartData[] = isset($monthlySalesData[$day]) ? $monthlySalesData[$day] : 0;
         }
     
         // Pass the data to the view
         $data['lineChartLabels'] = $labels;
         $data['lineChartData'] = $chartData;
     
         $data['table'] = Enrollment::getTableName();
     
         return view('dashboard.index', $data);
     }
     
        
        
 }

 