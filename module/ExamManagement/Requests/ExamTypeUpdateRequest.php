<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamTypeUpdateRequest extends FormRequest
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
            'type'      => ['required', 'min:2', 'max:255', 'unique_with:em_exam_types,' . $this->exam_type->id],
            'slug'      => ['required', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9-]+$/', 'unique:em_exam_types,slug,' . $this->exam_type->id],
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
            'type.required'         => 'Type is required.',
            'type.min'              => 'Type must be min 2 characters.',
            'type.max'              => 'Type must be max 255 characters.',
            'type.unique_with'      => 'This Name combination already exist',
            'slug.required'         => 'Slug is required.',
            'slug.min'              => 'Slug must be min 2 characters.',
            'slug.max'              => 'Slug must be max 255 characters.',
            'slug.regex'            => 'Slug format is invalid. You can use (hyphen(-)) for separate words.',
            'slug.unique'           => 'Slug already exist!',

        ];
    }
}
