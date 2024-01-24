<?php

namespace Module\EnrollmentManagement\Models;

use App\Models\Model;
use App\Models\PaymentMethod;
use App\Models\User;

class Enrollment extends Model
{

    protected $statusOptions = [
        'paid' => 'Paid',
        'due' => 'Due',
    ];


    protected $table = 'em_enrollments';


    public function scopeAuthorize($query)
    {
        $query->where('student_id', auth()->id());
    }
    public function couponUses()
    {
        return $this->hasMany(CouponUses::class, 'coupon_id', 'coupon_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(User::class, 'course_id', 'id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }


    public function enrollmentItems()
    {
        return $this->hasMany(EnrollmentItem::class, 'enrollment_id', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }


    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by', 'id');
    }
    
}
