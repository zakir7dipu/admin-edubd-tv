<?php

namespace Module\WebsiteCMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryStoreRequest extends FormRequest
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
            'serial_no' => ['required', 'numeric', 'unique:web_cms_blog_categories,serial_no'],
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
            'serial_no.required' => 'Serial No is required.',
            'serial_no.numeric' => 'Serial No must be a number.',
            'serial_no.unique' => 'Serial No already exist!',
        ];
    }
}
