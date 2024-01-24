<?php

namespace Module\ExamManagement\Models;

use App\Models\Model;

class Institute extends Model
{
    protected $table = 'em_institutes';

    public function exam()
    {
       return $this->hasMany(Exam::class,'institute_id','id');
    }
}
