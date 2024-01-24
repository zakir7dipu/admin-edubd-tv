<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class QuizTest extends Model
{
    protected $table = 'em_quiz_tests';


    public function User(){
        return $this->belongsTo(User::class,'student_id','id');
    }


    public function examChapter(){
        return $this->belongsTo(ExamChapter::class,'chapter_id','id');
    }


    public function quizTestQuizzes(){
        return $this->hasMany(QuizTestQuizzes::class, 'quiz_test_id','id');
    }
}
