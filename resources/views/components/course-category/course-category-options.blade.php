@props(['categoryId' => null, 'parentId' => null, 'courseCategoryId' => null, 'childCourseCategories'])
@php
    if (isset($categoryId) && $categoryId != null) {
        $courseCategories = $courseCategories->where('id', '!=', $categoryId);
    }
@endphp
@foreach ($courseCategories as $parentCourseCategory)
    <option value="{{ $parentCourseCategory->id }}" 
        {{ isset($courseCategoryId) && old('course_category_id', $courseCategoryId) == $parentCourseCategory->id ? 'selected' : '' }}
        {{ isset($courseCategoryId) && $courseCategoryId == $parentCourseCategory->id ? 'selected' : '' }}
        {{ isset($parentId) && old('parent_id', $parentId) == $parentCourseCategory->id ? 'selected' : '' }}
        {{ isset($parentId) && $parentId == $parentCourseCategory->id ? 'selected' : '' }}
        {{ old('course_category_id') == $parentCourseCategory->id ? 'selected' : '' }}
        {{ old('parent_id') == $parentCourseCategory->id ? 'selected' : '' }}
        {{ request('id') != '' && request('id') == $parentCourseCategory->id ? 'selected' : '' }}
        {{ request('parent_id') != '' && request('parent_id') == $parentCourseCategory->id ? 'selected' : '' }}
        {{ request('course_category_id') != '' && request('course_category_id') == $parentCourseCategory->id ? 'selected' : '' }}
    >
        {{ $parentCourseCategory->name }}
    </option>

    @php
        if (isset($categoryId) && $categoryId != null) {
            $parentCourseCategory->childCourseCategories = $parentCourseCategory->childCourseCategories->where('id', '!=', $categoryId);
        }
    @endphp
    @foreach ($parentCourseCategory->childCourseCategories as $parentCourseCategory)
        <option value="{{ $parentCourseCategory->id }}" 
            {{ isset($courseCategoryId) && old('course_category_id', $courseCategoryId) == $parentCourseCategory->id ? 'selected' : '' }}
            {{ isset($courseCategoryId) && $courseCategoryId == $parentCourseCategory->id ? 'selected' : '' }}
            {{ isset($parentId) && old('parent_id', $parentId) == $parentCourseCategory->id ? 'selected' : '' }}
            {{ isset($parentId) && $parentId == $parentCourseCategory->id ? 'selected' : '' }}
            {{ old('course_category_id') == $parentCourseCategory->id ? 'selected' : '' }}
            {{ old('parent_id') == $parentCourseCategory->id ? 'selected' : '' }}
            {{ request('id') != '' && request('id') == $parentCourseCategory->id ? 'selected' : '' }}
            {{ request('parent_id') != '' && request('parent_id') == $parentCourseCategory->id ? 'selected' : '' }}
            {{ request('course_category_id') != '' && request('course_category_id') == $parentCourseCategory->id ? 'selected' : '' }}
        >
            &nbsp;&raquo;&nbsp;{{ $parentCourseCategory->name }}
        </option>

        <x-course-category.course-child-category-options 
            :categoryId="$categoryId"
            :parentId="$parentId"
            :courseCategoryId="$courseCategoryId"
            :childCourseCategories="$parentCourseCategory->childCourseCategories" 
            :space="1" 
        />
    @endforeach
@endforeach