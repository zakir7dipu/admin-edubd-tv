@props(['categoryId' => null, 'parentId' => null, 'examCategoryId' => null, 'childExamCategories', 'space'])
@php
    if (isset($categoryId) && $categoryId != null) {
        $childExamCategories = $childExamCategories->where('id', '!=', $categoryId);
    }
@endphp
@foreach ($childExamCategories as $parentExamCategory)
    <option value="{{ $parentExamCategory->id }}" 
        {{ isset($examCategoryId) && old('exam_category_id', $examCategoryId) == $parentExamCategory->id ? 'selected' : '' }}
        {{ isset($examCategoryId) && $examCategoryId == $parentExamCategory->id ? 'selected' : '' }}
        {{ isset($parentId) && old('parent_id', $parentId) == $parentExamCategory->id ? 'selected' : '' }}
        {{ isset($parentId) && $parentId == $parentExamCategory->id ? 'selected' : '' }}
        {{ old('exam_category_id') == $parentExamCategory->id ? 'selected' : '' }}
        {{ old('parent_id') == $parentExamCategory->id ? 'selected' : '' }}
        {{ request('id') != '' && request('id') == $parentExamCategory->id ? 'selected' : '' }}
        {{ request('parent_id') != '' && request('parent_id') == $parentExamCategory->id ? 'selected' : '' }}
        {{ request('exam_category_id') != '' && request('exam_category_id') == $parentExamCategory->id ? 'selected' : '' }}
    >
        @for($s = 0; $s < $space; $s++)
            &nbsp;
        @endfor
        &raquo;&nbsp;{{ $parentExamCategory->name }}
    </option>

    <x-exam-category.exam-child-category-options 
        :categoryId="$categoryId"
        :parentId="$parentId"
        :examCategoryId="$examCategoryId"
        :childExamCategories="$parentExamCategory->childExamCategories" 
        :space="$space + 1" 
    />
@endforeach