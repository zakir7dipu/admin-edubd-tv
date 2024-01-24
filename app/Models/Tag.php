<?php

namespace App\Models;

use App\Models\Model;

class Tag extends Model
{
    /*
     |--------------------------------------------------------------------------
     | COURSE TAGS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function courseTags()
    {
        return $this->hasMany(Tag::class, 'tag_id', 'id');
    }
}
