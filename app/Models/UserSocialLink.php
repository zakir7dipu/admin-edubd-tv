<?php

namespace App\Models;


use App\Models\Model;

class UserSocialLink extends Model
{
    protected $table = 'user_social_links';
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
