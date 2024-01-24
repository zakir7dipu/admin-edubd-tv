<?php

namespace Module\CourseManagement\Models;

use App\Models\User;
use App\Models\Model;
use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Support\Facades\Storage;

class CourseLesson extends Model
{
    protected $table = "cm_course_lessons";

    protected $casts = [
        'description'               => CleanHtml::class,
        'assignment_description'    => CleanHtml::class,
    ];





    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }





    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }


    public function courseTopics()
    {
        return $this->belongsTo(CourseTopic::class, 'course_topic_id', 'id');
    }



    public function scopeFreeVideos($query)
    {
        $query->where('is_free', 1);
    }



    public function getAttachmentAttribute()
    {
        try {
            $attachment = $this->attributes['attachment'];
            $path = Storage::cloud()->url($attachment);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:application/pdf;base64,' . chunk_split(base64_encode($data));
        } catch (\Throwable $th) {
            return 'data:application/pdf;base64,' . chunk_split(base64_encode(''));
        }
    }


    public function lessonReview()
    {
        return $this->hasMany(LessonsReview::class, 'lesson_id', 'id');
    }
    public function lessonQuiz()
    {
        return $this->hasMany(LessonQuiz::class,'lesson_id', 'id');
    }
    public function lessonTracking()
    {
        return $this->hasMany(LessonTracking::class,'lesson_id', 'id');
    }
}
