<?php

namespace Module\EnrollmentManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\EnrollmentManagement\Models\Coupon;
use Module\CourseManagement\Models\Course;
use Module\EnrollmentManagement\Requests\CouponStoreRequest;
use Module\EnrollmentManagement\Requests\CouponUpdateRequest;
use App\Traits\CheckPermission;

class CouponsController extends Controller
{
    use CheckPermission;


    /*
    |--------------------------------------------------------------------------
    | INDEX METHOD
    |--------------------------------------------------------------------------
    */


    public function index()
    {
        $this->hasAccess("coupon-vew");

        $data['coupons'] = Coupon::paginate(20);
        $data['table']      = Coupon::getTableName();
        return view('coupon/index', $data);
    }






    /*
    |--------------------------------------------------------------------------
    | CREATE METHOD
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->hasAccess("coupon-create");
        $data['courses'] = Course::pluck('title', 'id');

        return view('coupon/create', $data);
    }






    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */

    public function store(CouponStoreRequest $request)
    {
        try {
            // $request->validated();

            DB::transaction(function () use ($request) {

                $slider = Coupon::create([
                    // 'use_type'             => $request->use_type,
                    'name'                 => $request->name,
                    'course_id'            => $request->course_id,
                    'code'                 => $request->code,
                    'start_date'           => $request->start_date,
                    'end_date'             => $request->end_date,
                    'amount'               => $request->amount ?? 0,
                    'uses_times'           => $request->uses_times,
                    'percentage'           => $request->percentage,
                    'description'          => $request->description,
                    'status'               => $request->status ?? 0,
                ]);

            });

            return redirect()->route('em.coupon.index')->withMessage('Coupon has been created successfully!');
        } catch (\Throwable $th) {

            return redirect()->route('em.coupon.index')->withErrors($th->getMessage());
        }
    }






    /*
    |--------------------------------------------------------------------------
    | EDIT METHOD
    |--------------------------------------------------------------------------
    */


    public function edit($id)
    {
        $this->hasAccess("coupon-edit");

        $data['courses'] = Course::pluck('title', 'id');
        $data['coupon']        = Coupon::find($id);
        $data['coupons']       = Coupon::all();
        return view('coupon/edit', $data);
    }





    /*
    |--------------------------------------------------------------------------
    | UPDATE METHOD
    |--------------------------------------------------------------------------
    */

    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        try {
            $request->validated();

            DB::transaction(function () use ($request, $coupon) {
            if($request->useType == 'amount'){
                $coupon->update([
                    'name'         => $request->name,
                    'course_id'    => $request->course_id,
                    'code'         => $request->code,
                    'start_date'   => $request->start_date,
                    'end_date'     => $request->end_date,
                    'amount'       => $request->amount,
                    'uses_times'   => $request->uses_times,
                    'percentage'   => null,
                    'description'  => $request->description,
                    'status'       => $request->status ?? 0,
                ]);
            }elseif($request->useType == 'percentage'){
                $coupon->update([
                    'name'         => $request->name,
                    'course_id'    => $request->course_id,
                    'code'         => $request->code,
                    'start_date'   => $request->start_date,
                    'end_date'     => $request->end_date,
                    'amount'       =>  null,
                    'uses_times'   => $request->uses_times,
                    'percentage'   => $request->percentage,
                    'description'  => $request->description,
                    'status'       => $request->status ?? 0,
                ]);
            }
               
                
            });

            return redirect()->route('em.coupon.index')->withMessage('Coupon has been updated successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('em.coupon.index')->withErrors($th->getMessage());
        }
    }






    /*
    |--------------------------------------------------------------------------
    | DESTROY METHOD
    |--------------------------------------------------------------------------
    */

    public function destroy(Coupon $coupon)
    {
        try {
            DB::transaction(function () use ($coupon) {

                $coupon->delete();
            });

            return redirect()->route('em.coupon.index')->withMessage('Coupon has been deleted successfully!');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Coupon');
        }
    }

}
