<?php

namespace Module\EnrollmentManagement\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\PaymentMethod;
use Module\CourseManagement\Models\Course;
use Module\EnrollmentManagement\Models\Enrollment;

class EnrollmentItem extends Model
{
    protected $table = 'em_enrollment_items';

    public function scopeAuthorize($query)
    {
        $query->where('student_id', auth()->id());
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    
}
