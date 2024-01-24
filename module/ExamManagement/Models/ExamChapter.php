<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class ExamChapter extends Model
{
    protected $table = 'em_exam_chapters';
    /*
     |--------------------------------------------------------------------------
     | EXAM (RELATION)
     |--------------------------------------------------------------------------
    */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function examQuizzes()
    {
        return $this->hasMany(ExamQuiz::class, 'chapter_id');
    }

     /*
     |--------------------------------------------------------------------------
     | PUBLISHED (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeActivePublish($query)
    {
        $query->where(['is_published' => 1, 'status' => 1]);
    }


    /*
     |--------------------------------------------------------------------------
     | ACTIVE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeChapterActive($query)
    {
        $query->where('status', 1);
    }


    /*
     |--------------------------------------------------------------------------
     | PUBLISHED ACTIVE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeExamChapterPublishedActive($query)
    {
        $query->where(['is_published' => 1, 'status' => 1]);
    }

}
