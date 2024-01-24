<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;
use Module\CourseManagement\Models\CourseLesson;

class LessonsReview extends Model
{
    protected $table = 'cm_lessons_reviews';

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id', 'id');
    }
    public function student(){
        {
            return $this->belongsTo(User::class, 'user_id', 'id');
        }
    }

}
