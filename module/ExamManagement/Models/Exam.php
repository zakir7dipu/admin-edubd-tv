<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class Exam extends Model
{
    protected $table = 'em_exams';





    /*
     |--------------------------------------------------------------------------
     | FREE EXAM (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeFreeExam($query)
    {
        $query->where('exam_fee', 0);
    }





    /*
     |--------------------------------------------------------------------------
     | PAID EXAM (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopePaidExam($query)
    {
        $query->where('exam_fee', '>', 0);
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM CATEGORY (RELATION)
    |--------------------------------------------------------------------------
    */
    public function examCategory()
    {
        return $this->belongsTo(ExamCategory::class, 'exam_category_id', 'id');
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM TYPE (RELATION)
    |--------------------------------------------------------------------------
    */
    public function examType()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id', 'id');
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM YEAR (RELATION)
    |--------------------------------------------------------------------------
    */
    public function examYear()
    {
        return $this->belongsTo(ExamYear::class, 'exam_year_id', 'id');
    }





    /*
    |--------------------------------------------------------------------------
    | INSTITUTE (RELATION)
    |--------------------------------------------------------------------------
    */
    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id', 'id');
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM CHAPTERS (RELATION)
    |--------------------------------------------------------------------------
    */
    public function examChapters()
    {
        return $this->hasMany(ExamChapter::class, 'exam_id');
    }





    /*
    |--------------------------------------------------------------------------
    | EXAM QUIZZES (RELATION)
    |--------------------------------------------------------------------------
    */
    public function examQuizzes()
    {
        return $this->hasMany(ExamQuiz::class, 'exam_id');
    }


     /*
     |--------------------------------------------------------------------------
     | EXAM CHAPTER PUBLISHED ACTIVE (RELATION)
     |--------------------------------------------------------------------------
    */



}
