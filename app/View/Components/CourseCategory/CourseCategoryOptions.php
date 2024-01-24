<?php

namespace App\View\Components\CourseCategory;

use Illuminate\View\Component;
use Module\CourseManagement\Models\CourseCategory;

class CourseCategoryOptions extends Component
{
    public $categoryId;
    public $parentId;
    public $courseCategoryId;
    public $courseCategories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categoryId = null, $parentId = null, $courseCategoryId = null, $courseCategories = [])
    {
        $this->categoryId       = $categoryId;
        $this->parentId         = $parentId;
        $this->courseCategoryId = $courseCategoryId;
        $this->courseCategories = $courseCategories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->courseCategories = CourseCategory::query()
                                ->where('parent_id', null)
                                ->with('childCourseCategories')
                                ->orderBy('name', 'ASC')
                                ->get(['id', 'parent_id', 'name', 'slug']);

        return view('components.course-category.course-category-options');
    }
}
