<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['required'],
            'description' => ['min:2'],
            'position' => ['required'],
            'serial_no' => ['required', 'numeric', 'unique:web_cms_pages,serial_no'],
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
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be min 2 characters.',
            'name.max' => 'Name must be max 255 characters.',
            'slug' => 'Slug is required',

            'description.min' => 'Description must be min 2 characters.',
            'position.required' =>'Position is required',
            'serial_no.required' => 'Serial No is required.',
            'serial_no.numeric' => 'Serial No must be a number.',
            'serial_no.unique' => 'Serial No already exist!',
        ];
    }
}