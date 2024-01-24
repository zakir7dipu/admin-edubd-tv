<?php

namespace Module\WebsiteCMS\Models;

use App\Models\Model;


class About extends Model
{
    protected $table = 'web_cms_abouts';





    /*
     |--------------------------------------------------------------------------
     | ABOUT COUNT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function aboutCounts()
    {
        return $this->hasMany(AboutCount::class, 'about_id','id');
    }




    // public function getBackgroundImageAttribute()
    // {
    //     $image = $this->attributes['background_image'];

    //     if ($image && file_exists(public_path($image))) {
    //         return $image;
    //     } else {
    //         return 'default-img.jpg';
    //     }
    // }
}
