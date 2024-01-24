<?php

namespace Module\EnrollmentManagement\Service;

use Module\EnrollmentManagement\Models\Enrollment;
use Module\EnrollmentManagement\Models\Order;
use Illuminate\Support\Str;
class EnrollmentService
{
    public $enrollment;





    /*
     |--------------------------------------------------------------------------
     | STORE ENROLLMENT
     |--------------------------------------------------------------------------
    */
    public function storeEnrollment($request)
    {
        $tran_id    = Str::upper(Str::random(10));
        // `subtotal` + `total_vat_amount` - `item_total_discount_amount` - `coupon_discount_amount`
        $total= $request->subtotal + $request->total_vat_amount - $request->item_total_discount_amount -$request->coupon_discount_amount;

        if($total <0 ){
            $total = 0;
        }

        return $this->enrollment = Enrollment::create([
            'student_id'                    => auth()->id(),
            'coupon_id'                     => $request->coupon_id,
            'invoice_no'                    => enrollmentInvoiceNo(),
            'date'                          => date('Y-m-d'),
            'total_quantity'                => array_sum($request->quantity),
            'subtotal'                      => $request->subtotal,
            'total_vat_amount'              => $request->total_vat_amount,
            'item_total_discount_amount'    => $request->item_total_discount_amount,
            'coupon_discount_amount'        => $request->coupon_discount_amount,
            'payment_status'                => $request->payment_status ?? 'Due',
            'payment_tnx_no'                => $tran_id,
            'grand_total'                   => $total,
            'payment_method_id'             => 1, // Initial it is 1. When using multiple payment method then it will be insert by request.
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE ENROLLMENT ITEMS
     |--------------------------------------------------------------------------
    */
    public function storeEnrollmentItems($request)
    {
        foreach ($request->course_id as $key => $course_id) {
            $this->enrollment->enrollmentItems()->create([
                'course_id'         => $course_id,
                'regular_fee'       => $request->regular_fee[$key] ?? 0,
                'discount_amount'   => $request->discount_amount[$key] ?? 0,
                'course_fee'        => $request->course_fee[$key] ?? 0,
                'quantity'          => $request->quantity[$key] ?? 0,
            ]);
        }
    }
}
