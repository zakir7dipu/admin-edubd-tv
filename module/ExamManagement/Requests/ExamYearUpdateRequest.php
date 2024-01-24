<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamYearUpdateRequest extends FormRequest
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
            'year'      => ['required', 'min:2', 'max:255', 'unique_with:em_exam_years,' . $this->exam_year->id],

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
            'year.required'         => 'Year is required.',
            'year.min'              => 'Year must be min 2 characters.',
            'year.max'              => 'Year must be max 255 characters.',
            'year.unique_with'      => 'This Year combination already exist',

        ];
    }
}
