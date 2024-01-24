<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\Course;


class LessonTracking extends Model
{
    protected $table = 'cm_course_lessons_tracking';


    public function User(){
        return $this->belongsTo(User::class,'student_id','id');
    }

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
