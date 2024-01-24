<?php

namespace Module\UserAccess\Models;

use App\Models\Model;

class PermissionUser extends Model
{
    protected $table = 'permission_user';
    




    /*
     |--------------------------------------------------------------------------
     | PERMISSION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function permission()
    {
        return $this->belongsTo(Permissidon::class);
    }
}
