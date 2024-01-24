<?php

namespace Module\WebsiteCMS\Models;

use App\Models\Model;
use Module\CourseManagement\Models\Course;

class Slider extends Model
{
    protected $table = "web_cms_sliders";


    /*
     |--------------------------------------------------------------------------
     | COURSE  (RELATION)
     |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
