<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use Module\CourseManagement\Models\CourseLesson;
use Module\CourseManagement\Models\LessonQuizOption;


class LessonQuiz extends Model
{
    protected $table = 'cm_lesson_quizzes';




    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id', 'id');
    }


    public function lessonQuizOption()
    {
        return $this->hasMany(LessonQuizOption::class, 'lesson_quiz_id', 'id');
    }
}
