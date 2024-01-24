<?php

use Illuminate\Support\Str;



function getSidebarName($menu)
{
    $lower_menu     = strtolower($menu->name);
    $sidebar_path   = 'sidebars.__sidebar_' . Str::snake($lower_menu);
    $sidebar_path   = str_replace('&', '', $sidebar_path);

    return $sidebar_path;
}



function nextSerialNo($model)
{
    return optional($model::serialNoDesc()->first())->serial_no + 1;
}



function courseTypes()
{
    return ['Professional', 'Academic'];
}



function genders()
{
    return ['Male', 'Female', 'Others'];
}



function calculateTotalDurations($durations)
{
    $totalSeconds = 0;

    try {
        foreach ($durations as $duration) {
            
            if ($duration != '' || $duration != null) {
                try {
                    list($hour, $minute, $second) = explode(':', $duration);

                    $hourInSeconds      = ($hour * 60) * 60;
                    $minuteInSeconds    = $minute * 60;
                    $totalSeconds       += $hourInSeconds + $minuteInSeconds + $second;

                } catch (\Exception $ex) {
                    $totalSeconds       += 0;
                }
            }
        }

        $secs   = $totalSeconds % 60;
        $hrs    = $totalSeconds / 60;
        $mins   = $hrs % 60;
        $hrs    = $hrs / 60;
        
    } catch (\Throwable $th) {
        $hrs    = 0;
        $mins   = 0;
        $hrs    = 0;
    }

    return sprintf('%02d:%02d:%02d', $hrs, $mins, $secs);
}



function getGoogleDriveUrl($path)
{
    return 'https://drive.google.com/uc?id=' . $path . '&export=media';
}

function permissionSlug()
{
    return auth()->id()->permissions()->pluck('slug')->toArray();
}



/**
 * ------------------------------------------------------------
 * CHECK USER HAS PERMISSION OR NOT IN SPECIFIC ROUTE
 * ------------------------------------------------------------
 */
function hasPermission($slug, $permission_slugs = null)
{
    if (auth()->id() == 1) {
        return true;
    }

    if ($permission_slugs == null) {
        $permission_slugs = permissionSlug();
    }

    return in_array($slug, $permission_slugs);
}




/*
* --------------------------------------------------------------------------
* Permission: Permission Any
* --------------------------------------------------------------------------
*/
function hasAnyPermission($input_slugs, $permission_slugs)
{
    if (auth()->id() == 1) {
        return true;
    } else {
        if (count(array_intersect($permission_slugs, $input_slugs)) !== 0) {
            return true;
        } else {
            return false;
        }
    }
}


function activeModules()
{
    return Module::active()->pluck('name')->toArray();
}




/*
* --------------------------------------------------------------------------
* Permission: Permission For Module
* --------------------------------------------------------------------------
*/
function hasModulePermission($module_name, $activae_modules)
{
    return in_array($module_name, $activae_modules);
}
