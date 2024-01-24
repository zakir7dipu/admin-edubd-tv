<?php

namespace Module\UserAccess\Models;

use App\Models\Model;

class Permission extends Model
{
    /*
     |--------------------------------------------------------------------------
     | PARENT PERMISSION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function parentPermission()
    {
        return $this->belongsTo(ParentPermission::class, 'parent_permission_id', 'id');
    }
}
