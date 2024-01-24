<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportUpdateRequest extends FormRequest
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

            'description' => ['min:2', 'max:500'],


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

            'description.min' => 'Description must be min 2 characters.',
            'description.max' => 'Description must be max 500 characters.',

        ];
    }
}
