<?php

namespace Module\WebsiteCMS\Models;


use App\Models\Model;
use App\Models\User;

class Blog extends Model
{
    protected $table = 'web_cms_blogs';
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
