<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqsUpdateRequest extends FormRequest
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
            'title' => ['min:2', 'max:255'],
            'description' => [ 'min:2', 'max:500'],
            'serial_no' => ['required', 'numeric', 'unique:web_cms_faqs,serial_no,' . $this->faq->id],
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
            'title.min' => 'Title must be min 2 characters.',
            'title.max' => 'Title must be max 255 characters.',
            'description.min' => 'Description must be min 2 characters.',
            'description.max' => 'Description must be max 500 characters.',
            'serial_no.required' => 'Serial No is required.',
            'serial_no.numeric' => 'Serial No must be a number.',
            'serial_no.unique' => 'Serial No already exist!',
        ];
    }
}
