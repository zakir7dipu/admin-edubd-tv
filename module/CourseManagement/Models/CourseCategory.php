<?php

namespace Module\CourseManagement\Models;

use App\Models\Model;
class CourseCategory extends Model
{
    protected $table = 'cm_course_categories';
    
    
    /*
     |--------------------------------------------------------------------------
     | HIGHLIGHTED (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeHighlighted($query)
    {
        $query->where('is_highlighted', 1);
    }
    
    
    /*
     |--------------------------------------------------------------------------
     | SHOW IN MENU (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeShowInMenu($query)
    {
        $query->where('show_in_menu', 1);
    }

    
    /*
     |--------------------------------------------------------------------------
     | PARENT COURSE CATEGORY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function parentCourseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id', 'id');
    }


    /*
     |--------------------------------------------------------------------------
     | PARENT COURSE CATEGORIES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function parentCourseCategories()
    {
        return  $this->hasMany(CourseCategory::class, 'id', 'parent_id')
                ->with('parentCourseCategories')
                ->select('id', 'parent_id', 'name', 'slug');
    }


    /*
    |--------------------------------------------------------------------------
    | CHILD COURSE CATEGORY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function childCourseCategories()
    {
        return  $this->hasMany(CourseCategory::class, 'parent_id', 'id')
                ->with(['childCourseCategories' => function($query) {
                    $query->serialNoAsc()
                    ->select('id', 'parent_id', 'name', 'slug');
                }])
                ->serialNoAsc()
                ->select('id', 'parent_id', 'name', 'slug');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW IN MENU CHILD COURSE CATEGORY (METHOD)
    |--------------------------------------------------------------------------
    */
    public function showInMenuChildCourseCategories()
    {
        return  $this->hasMany(CourseCategory::class, 'parent_id', 'id')
                ->with(['showInMenuChildCourseCategories' => function($query) {
                    $query
                    ->showInMenu()
                    ->serialNoAsc()
                    ->select('id', 'parent_id', 'name', 'slug');
                }])
                ->showInMenu()
                ->serialNoAsc()
                ->select('id', 'parent_id', 'name', 'slug');
    }
}
