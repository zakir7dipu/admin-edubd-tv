<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;


class ExamQuiz extends Model
{
    protected $table = 'em_exam_quizzes';


    /*
    |--------------------------------------------------------------------------
    | EXAM  (RELATION)
    |--------------------------------------------------------------------------
    */
    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id','id');
    }


    public function examCategory(){
        return $this->belongsTo(ExamCategory::class, 'exam_category_id','id');
    }
    public function examChapters(){
        return $this->belongsTo(ExamChapter::class, 'chapter_id','id');
    }


    public function quizOptions()
    {
        return $this->hasMany(QuizOption::class, 'exam_quiz_id');
    }

    public function quizTestQuizzes(){
        return $this->hasMany(QuizTestQuizzes::class, 'quiz_test_id','id');
    }

     /*
     |--------------------------------------------------------------------------
     | ACTIVE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeQuizActive($query)
    {
        $query->where('status', 1);
    }


}
