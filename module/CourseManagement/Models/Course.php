<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
use App\Models\User;
use Module\WebsiteCMS\Models\Slider;

class Course extends Model
{
    protected $table = 'cm_courses';


    /*
     |--------------------------------------------------------------------------
     | FREE COURSE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeFreeCourse($query)
    {
        $query->where('course_fee', 0);
    }


    /*
     |--------------------------------------------------------------------------
     | PAID COURSE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopePaidCourse($query)
    {
        $query->where('course_fee', '>', 0);
    }


    /*
     |--------------------------------------------------------------------------
     | POPULAR COURSE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopePopularCourse($query)
    {
        $query->where('is_popular', 1);
    }


    /*
     |--------------------------------------------------------------------------
     | PREMIER COURSE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopePremierCourse($query)
    {
        $query->where('is_premier', 1);
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE CATEGORY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE LEVEL (RELATION)
     |--------------------------------------------------------------------------
    */
    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE LANGUAGE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function language()
    {
        return $this->belongsTo(CourseLanguage::class, 'course_language_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE INTRODUCTIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseIntroductions()
    {
        return $this->hasMany(CourseIntroduction::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE INSTRUCTORS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseInstructors()
    {
        return $this->hasMany(CourseInstructor::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE OUTCOMES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseOutcomes()
    {
        return $this->hasMany(CourseOutcome::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE FAQS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseFAQs()
    {
        return $this->hasMany(CourseFAQ::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE TOPICS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseTopics()
    {
        return $this->hasMany(CourseTopic::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE PUBLISHED ACTIVE TOPICS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function coursePublishedActiveTopics()
    {
        return $this->hasMany(CourseTopic::class, 'course_id', 'id')->published()->active();
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE LESSONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseLessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE PUBLISHED ACTIVE LESSONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function coursePublishedActiveLessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id', 'id')->published()->active();
    }


    /*
     |--------------------------------------------------------------------------
     | SLIDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function slider()
    {
        return $this->hasMany(Slider::class, 'course_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | PUBLISHED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | COURSE TAGS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseTags()
    {
        return $this->hasMany(CourseTag::class, 'course_id', 'id');
    }
    public function courseReview()
    {
        return $this->hasMany(CourseReview::class, 'course_id', 'id');
    }
    public function lessonTracking()
    {
        return $this->hasMany(LessonTracking::class,'course_id', 'id');
    }
}
