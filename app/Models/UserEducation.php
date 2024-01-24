<?php

namespace App\Models;

use App\Models\Model;

class UserEducation extends Model
{
    /*
     |--------------------------------------------------------------------------
     | USER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
