<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamCategoryUpdateRequest extends FormRequest
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'min:2', 'max:255', 'unique_with:em_exam_categories,name,parent_id,' . $this->exam_category->id],
            'slug'      => ['required', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9-]+$/', 'unique:em_exam_categories,slug,' . $this->exam_category->id],
            'serial_no' => ['required', 'numeric', 'unique:em_exam_categories,serial_no,' . $this->exam_category->id],
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
            'name.required'         => 'Name is required.',
            'name.min'              => 'Name must be min 2 characters.',
            'name.max'              => 'Name must be max 255 characters.',
            'name.unique_with'      => 'This Name combination already exist',
            'slug.required'         => 'Slug is required.',
            'slug.min'              => 'Slug must be min 2 characters.',
            'slug.max'              => 'Slug must be max 255 characters.',
            'slug.regex'            => 'Slug format is invalid. You can use (hyphen(-)) for separate words.',
            'slug.unique'           => 'Slug already exist!',
            'serial_no.required'    => 'Serial No is required.',
            'serial_no.numeric'     => 'Serial No must be a number.',
            'serial_no.unique'      => 'Serial No already exist!',
        ];
    }
}
