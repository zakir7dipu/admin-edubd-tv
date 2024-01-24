<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\Tag;

class CourseTag extends Model
{
    protected $table = 'cm_course_tags';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
