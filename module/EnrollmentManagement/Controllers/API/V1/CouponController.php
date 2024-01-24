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
        
        try {
            $request->validate([
                'code' => 'required',
            ]);
    
            $coupon = Coupon::where('code', $request->code)->first();
    
            if (!$coupon) {
                return $this->getResponse(0, 'Coupon is invalid!', null);
            }
            $usedTime = CouponUses::where('coupon_id', $coupon->id)->count();

            if ($coupon->uses_times !== null && $coupon->uses_times <= $usedTime) {
                return $this->getResponse(0, 'Coupon is now invalid!', null);
            }
    
            $alreadyUsed = CouponUses::where(['student_id' => auth()->id(), 'coupon_id' => $coupon->id])->first();
            if ($alreadyUsed) {
                return $this->getResponse(0, 'Already used!', null);
            }
    
            $checkCouponExpireOrNot = $coupon->end_date < date('Y-m-d');
    
            if ($checkCouponExpireOrNot) {
                return $this->getResponse(0, 'Coupon already expired!', null);
            }
            $couponByCourse = Coupon::where(['course_id' => $request->course_id, 'code' => $request->code])->first();

            if ($coupon->course_id !== null && !$couponByCourse) {
                return $this->getResponse(0, 'Coupon is invalid for this course!', null);
            }
    
            $couponData = [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'course_id' => $coupon->course_id,
            ];
    
            if ($coupon->amount > 0 && ($coupon->percentage === null || $coupon->percentage === 0)) {
                $couponData['amount'] = $coupon->amount;
                $couponData['percentage'] = 0;
            } elseif ($coupon->percentage !== null && $coupon->percentage > 0) {
                $couponData['percentage'] = $coupon->percentage;
                $couponData['amount'] = 0;

            } else {
               
                $couponData['percentage'] = $coupon->percentage?$coupon->percentage:0;
                $couponData['amount'] = $coupon->amount?$coupon->amount:0;

            }
           
            return $this->getResponse(1, 'Coupon added successfully!', $couponData);
    
        } catch (\Throwable $th) {
            return $this->getResponse(0, 'There was an error!', null, $th->getMessage());
        }
    }
    
    private function getResponse($status, $message, $data, $error = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ]);
    }
    
    public function couponCheck($code) {
        try {
            $coupon = Coupon::where('code', $code)->get();
    
            return response()->json([
                'status'  => 1,
                'message' => $coupon->isNotEmpty() ? 'Success' : 'No coupon found!',
                'data'    => $coupon,
                'errors'  => null
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message' => 'There was an error!',
                'data'    => '',
                'error'   => $th->getMessage()
            ]);
        }
    }
    
}