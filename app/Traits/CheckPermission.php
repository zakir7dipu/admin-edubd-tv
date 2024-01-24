<?php

namespace App\Traits;

use Module\UserAccess\Models\Permission;
use Module\UserAccess\Models\PermissionUser;

trait CheckPermission {
    




    /*
     |--------------------------------------------------------------------------
     | HAS ACCESS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function hasAccess($slug)
    {
        if (auth()->id() != 1) {
            $permission = Permission::where('slug', $slug)->first();
            if ($permission) {
                $permission_user = PermissionUser::where('permission_id', $permission->id)->where('user_id', auth()->id())->first();
                if (!$permission_user) {
                    redirect('/')->send();
                }
            } else {
                redirect('/')->send();
            }
        }
    }
    




    /*
     |--------------------------------------------------------------------------
     | HAS ACCESS ARRAY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function hasAccessArray($slugs): array
    {
        $out = array_map(function () {return 0;}, array_flip($slugs));

        if (auth()->id() != 1) {
            $permission_user = PermissionUser::query()
                ->with(['permission' => function ($q) use ($slugs) {
                    $q->whereIn('slug', $slugs);
                }])
                ->whereHas('permission', function ($q) use ($slugs) {
                    $q->whereIn('slug', $slugs);
                })
                ->where('user_id', auth()->id())
                ->get();
            foreach ($permission_user as $pUser) {
                if (in_array($pUser->permission->slug, $slugs)) {
                    $out[$pUser->permission->slug] = 1;
                }
            }
        } else {
            foreach ($out as &$value) {
                $value = 1;
            }
        }

        return $out;
    }
}
