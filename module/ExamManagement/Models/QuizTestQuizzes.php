<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class QuizTestQuizzes extends Model
{
    protected $table = 'em_quiz_test_quizzes';


    public function quizTest(){
        return $this->belongsTo(QuizTest::class,'quiz_test_id','id');
    }

    public function quiz(){
        return $this->belongsTo(ExamQuiz::class, 'quiz_id','id');
    }
}
