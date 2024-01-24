<?php

namespace Module\WebsiteCMS\Models;

use App\Models\Model;

class AboutCount extends Model
{
    protected $table = 'web_cms_about_counts';
    /*
     |--------------------------------------------------------------------------
     | ABOUT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function about()
    {
        return $this->belongsTo(About::class, 'about_id', 'id');
    }
}
