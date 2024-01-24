<?php

namespace Module\CourseManagement\Service;

use Module\CourseManagement\Models\CourseCategory;

class CategoryService
{
    /*
     |--------------------------------------------------------------------------
     | GET CATEGORIES IDS
     |--------------------------------------------------------------------------
    */
    public function getCategoryIds($request)
    {
        $categoryIds        = CourseCategory::query()
                            ->when(request()->filled('course_category_id'), function ($q) use ($request) {
                                // $q->with('childCourseCategories')
                                $q->where('id', $request->course_category_id);
                            })
                            ->with("childCourseCategories")
                            ->select("id")
                            ->get()->map(function ($item) {
                                return [
                                    'id'                    => $item->id,
                                    'course_category_id'    => $this->getChildCategoriesId($item->childCourseCategories)
                                ];
                            });

        $categories_id      = $categoryIds->flatten();

        return $categories_id;
    }








    /*
     |--------------------------------------------------------------------------
     | GET CHILD CATEGORIES ID METHOD
     |--------------------------------------------------------------------------
    */
    public function getChildCategoriesId($childCourseCategories)
    {   
        $category_ids = [];

        $childCourseCategories->map(function($item) use(&$category_ids) {

            $item->childCourseCategories->map(function($item) use(&$category_ids) {
                
                $category_ids[] = $item->id;
                $category_ids[] = $this->getChildCategoriesId($item->childCourseCategories);

                return $category_ids;
            });

            return $category_ids[] = $item->id;
        });

        return $category_ids;
    }
}