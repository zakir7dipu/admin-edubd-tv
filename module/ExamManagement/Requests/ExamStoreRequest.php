<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamStoreRequest extends FormRequest
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
            'title' => ['required', 'min:1','max:500'],
            // 'serial_no' => ['required', 'numeric', 'unique:em_exams,serial_no' . $this->exam->id],
            'slug'      => ['required', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9-]+$/', 'unique:em_exams'],
            'description' => ['max:1000'],

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
            'title.required'        => 'Title Must Be Required',
            'title.min'             => 'Title must be min 1 characters',
            'title.max'             => 'Title Not More Than 500 characters',
            'slug.required'         => 'Slug is required.',
            'slug.min'              => 'Slug must be min 2 characters.',
            'slug.max'              => 'Slug must be max 255 characters.',
            'slug.regex'            => 'Slug format is invalid. You can use (hyphen(-)) for separate words.',
            'slug.unique'           => 'Slug already exist!',
            'description.max'       => 'Description not more than 1000 characters',
        ];
    }
}
