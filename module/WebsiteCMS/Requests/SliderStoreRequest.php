<?php

namespace Module\WebsiteCMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
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
            'title'                 => ['required', 'min:2', 'max:255'],
            'image'                 => ['required', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'serial_no'             => ['required', 'numeric', 'unique:web_cms_sliders,serial_no'],
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
            'title.required'                => 'Title is required.',
            'title.min'                     => 'Title must be min 2 characters.',
            'title.max'                     => 'Title must be max 255 characters.',

            'image.required'                => 'Image is required.',
            'image.mimes'                   => 'Valid Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'serial_no.required'            => 'Serial No is required.',
            'serial_no.numeric'             => 'Serial No must be a number.',
            'serial_no.unique'              => 'Serial No already exist!',
        ];
    }
}
