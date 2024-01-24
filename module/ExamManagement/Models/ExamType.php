<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class ExamType extends Model
{
    protected $table = 'em_exam_types';
    public function exam()
    {
       return $this->hasMany(Exam::class,'exam_type_id','id');
    }
}
