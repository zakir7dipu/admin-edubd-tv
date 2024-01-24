<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;
use Module\CourseManagement\Models\CourseLesson;


class CourseTopic extends Model
{
    protected $table = 'cm_course_topics';




    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }




    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_topic_id', 'id');
    }
}
