<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialsUpdateRequest extends FormRequest
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
            'description' => ['required', 'min:2', 'max:500'],
            'image' => ['mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'serial_no' => ['required', 'numeric', 'unique:web_cms_testimonials,serial_no,' .$this->testimonial->id],

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
            'description.required' => 'Description is required.',
            'description.min' => 'Description must be min 2 characters.',
            'description.max' => 'Description must be max 500 characters.',
            'image.mimes' => 'Valid Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'serial_no.required' => 'Serial No is required.',
            'serial_no.numeric' => 'Serial No must be a number.',
            'serial_no.unique' => 'Serial No already exist!',
        ];
    }
}
