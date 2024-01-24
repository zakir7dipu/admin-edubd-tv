<?php

namespace Module\UserAccess\Models;

use App\Models\Model;

class Module extends Model
{
    /*
     |--------------------------------------------------------------------------
     | SUBMODULES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function submodules()
    {
        return $this->hasMany(Submodule::class);
    }
    
    public function scopeActive($q)
    {
        return $q->whereStatus(1);
    }
}
