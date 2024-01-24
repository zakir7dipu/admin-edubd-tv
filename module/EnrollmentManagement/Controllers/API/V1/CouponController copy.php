<?php

namespace Module\EnrollmentManagement\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Module\EnrollmentManagement\Models\Coupon;
use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Requests\CouponAmountRequest;
use Illuminate\Support\Facades\Auth;
use Module\EnrollmentManagement\Models\CouponUses;

class CouponController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | COUPON AMOUNT (METHOD)
    |--------------------------------------------------------------------------
    */
    public function couponAmount(CouponAmountRequest $request)
{
    $status = 0;
    $message = '';
    $data = [];

    try {
        $request->validate([
            'code' => 'required',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        $studentId = CouponUses::where('coupon_id', $coupon->id)->groupBy('student_id')->pluck('student_id');

        $couponUses = CouponUses::all();

        $checkCouponExpireOrNot = Coupon::where('code', $request->code)->where('end_date', '<', date('Y-m-d'))->first() ? true : false;
        $alreadyUsed = CouponUses::where(['student_id' => auth()->id(), 'coupon_id' => $coupon->id])->first();

        if ($coupon->course_id !== null) {
            $couponByCourse = Coupon::where(['course_id' => $request->course_id, 'code' => $request->code])->first();

            if (!$couponByCourse) {
                $message = 'Coupon is invalid!';
            } elseif ($checkCouponExpireOrNot) {
                $message = 'Coupon already expired!';
            } elseif ($alreadyUsed !== null) {
                $message = 'Already used!';
            } else {
                $coupon->couponUses()->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'student_id' => Auth::id()
                ]);
                $status = 1;
                $message = 'Coupon added successfully!';
                $data = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'amount' => $coupon->amount,
                    'percentage' => 0
                ];
            }
        } else {
            if ($studentId !== auth()->id() && ($coupon->amount > 0 && ($coupon->percentage === null || $coupon->percentage === 0))) {
                $coupon->couponUses()->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'student_id' => Auth::id()
                ]);
                $status = 1;
                $message = 'Coupon added successfully!';
                $data = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'amount' => $coupon->amount,
                    'percentage' => 0
                ];
            } else if ($studentId !== auth()->id()) {
                $coupon->couponUses()->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'student_id' => Auth::id()
                ]);
                $status = 1;
                $message = 'Coupon added successfully!';
                $data = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'amount' => 0,
                    'percentage' => $coupon->percentage
                ];
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 0,
            'message' => 'There was an error!',
            'data' => null,
            'error' => $th->getMessage()
        ]);
    }
}
}