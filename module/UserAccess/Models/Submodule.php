<?php

namespace Module\UserAccess\Models;

use App\Models\Model;

class Submodule extends Model
{
    /*
     |--------------------------------------------------------------------------
     | MODULE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }




    
    /*
     |--------------------------------------------------------------------------
     | PARENT PERMISSIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function parentPermissions()
    {
        return $this->hasMany(ParentPermission::class);
    }
}
