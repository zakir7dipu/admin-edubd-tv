<?php

namespace Module\EnrollmentManagement\Models;

use App\Models\Model;
use Module\CourseManagement\Models\Course;



class Coupon extends Model
{
    protected $table = 'em_coupons';



    public function couponUses()
    {
        return $this->hasMany(CouponUses::class, 'coupon_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
