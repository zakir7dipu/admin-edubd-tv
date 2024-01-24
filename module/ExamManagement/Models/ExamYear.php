<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class ExamYear extends Model
{
    protected $table = 'em_exam_years';
    public function exam()
    {
       return $this->hasMany(Exam::class,'exam_year_id','id');
    }
}
