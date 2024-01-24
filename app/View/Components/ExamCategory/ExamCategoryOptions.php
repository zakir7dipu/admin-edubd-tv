<?php

namespace App\View\Components\ExamCategory;

use Illuminate\View\Component;
use Module\ExamManagement\Models\ExamCategory;

class ExamCategoryOptions extends Component
{
    public $categoryId;
    public $parentId;
    public $examCategoryId;
    public $examCategories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categoryId = null, $parentId = null, $examCategoryId = null, $examCategories = [])
    {
        $this->categoryId       = $categoryId;
        $this->parentId         = $parentId;
        $this->examCategoryId   = $examCategoryId;
        $this->examCategories   = $examCategories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->examCategories   = ExamCategory::query()
                                ->where('parent_id', null)
                                ->with('childExamCategories')
                                ->orderBy('name', 'ASC')
                                ->get(['id', 'parent_id', 'name', 'slug']);

        return view('components.exam-category.exam-category-options');
    }
}
