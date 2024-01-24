<?php

namespace Module\CourseManagement\Models;


use App\Models\Model;
use App\Models\User;

class CourseInstructor extends Model
{
    protected $table = 'cm_course_instructors';





    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }





    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }
}
