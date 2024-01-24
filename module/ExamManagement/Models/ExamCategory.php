<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class ExamCategory extends Model
{
    protected $table = 'em_exam_categories';


    /*
     |--------------------------------------------------------------------------
     | PARENT EXAM CATEGORY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function parentExamCategory()
    {
        return $this->belongsTo(ExamCategory::class, 'parent_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | PARENT EXAM CATEGORIES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function parentExamCategories()
    {
        return  $this->hasMany(ExamCategory::class, 'id', 'parent_id')
                ->with('parentExamCategories')
                ->select('id', 'parent_id', 'name', 'slug');
    }


    /*
    |--------------------------------------------------------------------------
    | CHILD COURSE CATEGORY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function childExamCategories()
    {
        return  $this->hasMany(ExamCategory::class, 'parent_id', 'id')
                ->with(['childExamCategories' => function($query) {
                    $query->serialNoAsc()
                    ->select('id', 'parent_id', 'name', 'slug');
                }])
                ->serialNoAsc()
                ->select('id', 'parent_id', 'name', 'slug');
    }


    /*
     |--------------------------------------------------------------------------
     | EXAMS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function exams()
    {
       return $this->hasMany(Exam::class, 'exam_category_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | EXAM QUIZZES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function examQuizzes()
    {
        return $this->hasMany(ExamQuiz::class, 'exam_category_id', 'id');
    }
}
