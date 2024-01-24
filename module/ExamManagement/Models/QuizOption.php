<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class QuizOption extends Model
{
    protected $table = 'em_quiz_options';



    public function examQuiz(){
        return $this->belongsTo(ExamQuiz::class,'exam_quiz_id','id');
    }
}
