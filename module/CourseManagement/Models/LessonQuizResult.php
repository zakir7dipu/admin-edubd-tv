<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\LessonQuizOption;


class LessonQuizResult extends Model
{
    protected $table = 'cm_lesson_quiz_result';


    public function User(){
        return $this->belongsTo(User::class,'student_id','id');
    }

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id', 'id');
    }


    public function lessonQuizOption()
    {
        return $this->hasMany(LessonQuizOption::class, 'lesson_quiz_id', 'id');
    }
}
