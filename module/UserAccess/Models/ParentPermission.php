<?php

namespace Module\UserAccess\Models;

use App\Models\Model;

class ParentPermission extends Model
{
    /*
     |--------------------------------------------------------------------------
     | SUBMODULE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function submodule()
    {
        return $this->belongsTo(Submodule::class);
    }

    



    /*
     |--------------------------------------------------------------------------
     | PERMISSIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function permissions()
    {
        return $this->hasMany(Permission::class)->where('status', 1);
    }
}
