<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;

class LessonQuizOption extends Model
{
    protected $table = 'cm_lesson_quiz_options';


    public function lessonQuiz()
    {
        return $this->belongsTo(LessonQuiz::class, 'lesson_quiz_id', 'id');
    }
}
