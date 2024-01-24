<?php

namespace Module\EnrollmentManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\EnrollmentManagement\Models\Enrollment;
use App\Traits\CheckPermission;

class EnrollMentController extends Controller
{
    use CheckPermission;


    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("enrollment-list-vew");

                                   $startDate = $request->start_date ?? date('Y-m-d');
                                   $endDate = $request->end_date ?? date('Y-m-d');

        $data['enrolls']           = Enrollment::query()
                                   ->when(request('search'), function ($q) {
                                     $q->where(function ($q) {
                                     $q->where('invoice_no', 'like', '%' . request('search') . '%')
                                    ->orWhere('total_quantity', 'like', '%' . request('search') . '%');

                                    });
                                    })
                                    ->where('payment_status','Paid')
                                     ->with('student', 'paymentMethod', 'coupon')
                                     ->searchByField('student_id')
                                     ->searchByField('payment_method_id')
                                     ->when($request->filled('start_date'), function($q) use($startDate, $endDate){
                                        $q->whereBetween('date', [$startDate, $endDate]);
                                     })
                                     ->orderBy('date', 'desc')
                                     ->paginate(20);
                                    //  dd( $data['enrolls'] );


        $data['students']           = User::where('role_id', 3)->pluck('first_name', 'id');
        $data['paymentMethods']     = PaymentMethod::pluck('name', 'id');
        $data['table']              = Enrollment::getTableName();



        return view('enrollment/index', $data);
    }



     /*
    |--------------------------------------------------------------------------
    | DESTROY METHOD
    |--------------------------------------------------------------------------
    */


public function destroy(Enrollment $enrollment)
{
    try {
        DB::transaction(function () use ($enrollment) {
            $enrollment->enrollmentItems()->delete();
            $enrollment->delete();
        });

        return redirect()->route('em.enrollment.index')->with('message', 'Enrollment has been deleted successfully!');

    } catch (\Throwable $th) {
        return redirect()->back()->withErrors([$th->getMessage()]);
    }
}








    public function updateStatus(Request $request, $id)
{
    $enrollment = Enrollment::findOrFail($id);
    $payment_status = $request->payment_status;

    $enrollment->payment_status = ($payment_status === 'paid') ? 'Paid' : 'Due';
    $enrollment->save();
    return response()->json(['success' => true]);
}
}
