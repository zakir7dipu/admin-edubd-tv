<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;

class CourseReview extends Model
{
    protected $table = 'cm_course_reviews';



    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }


    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
