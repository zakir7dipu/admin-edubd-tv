<?php

namespace Module\EnrollmentManagement\Models;

use App\Models\Model;
use App\Models\User;

class CouponUses extends Model
{
    protected $table = 'em_coupon_uses';


    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
