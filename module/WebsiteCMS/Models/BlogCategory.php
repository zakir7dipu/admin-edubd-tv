<?php

namespace Module\WebsiteCMS\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class BlogCategory extends Model
{
    protected $table = 'web_cms_blog_categories';
    public function blog()
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
