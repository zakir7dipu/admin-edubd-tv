<?php

namespace Module\CourseManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_title'              => ['required', 'min:2'],
            'course_slug'               => ['required', 'min:2', 'max:300', 'regex:/^[a-zA-Z0-9-]+$/', 'unique:cm_courses,slug,' . $this->course->id],
            'course_fee'                => ['required'],
            'course_short_description'  => ['required'],
            'course_category_id'        => ['required'],
            'course_type'               => ['required'],
            'course_level_id'           => ['required'],
            'course_language_id'        => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'course_title.required'             => 'Course Title is required.',
            'course_title.min'                  => 'Course Title must be min 2 characters.',
            'course_slug.required'              => 'Course Slug is required.',
            'course_slug.min'                   => 'Course Slug must be min 2 characters.',
            'course_slug.max'                   => 'Course Slug must be max 300 characters.',
            'course_slug.regex'                 => 'Course Slug format is invalid. You can use (hyphen(-)) for separate words.',
            'course_slug.unique'                => 'Course Slug already exist',
            'course_fee.required'               => 'Course Fee is required.',
            'course_short_description.required' => 'Course Short Description is required.',
            'course_category_id.required'       => 'Course Category is required.',
            'course_type.required'              => 'Course Type is required.',
            'course_level_id.required'          => 'Course Level is required.',
            'course_language_id.required'       => 'Course Language is required.',
        ];
    }
}
