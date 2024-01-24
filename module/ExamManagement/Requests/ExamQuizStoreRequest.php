<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamQuizStoreRequest extends FormRequest
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
            'title'             => ['required'],
            'exam_category_id'  => ['required'],
            'exam_id'           => ['required'],
            'chapter_id'        => ['required'],
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
            'title.required'            => 'Title field is required',
            'exam_category_id.required' => 'Exam Category field is required',
            'exam_id.required'          => 'Exam field is required',
            'chapter_id.required'       => 'Chapter field is required',
        ];
    }
}
