<?php

namespace Module\WebsiteCMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUpdateRequest extends FormRequest
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
            'title'             => ['required','min:2', 'max:255'],
            'short_description' => ['required','min:10','max:500'],
            'description'       => ['max:1000'],
            'image'             => ['nullable', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'background_image'  => ['nullable', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
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
            'title.required'                => 'Title must be Required',
            'title.min'                     => 'Title must be min 2 characters.',
            'title.max'                     => 'Title must be max 255 characters.',
            'short_description.required'    => 'Short Description must be Required',
            'short_description.min'         => 'Short Description must be min 10 characters.',
            'short_description.max'         => 'Short Description must be max 255 characters.',
            'description.max'               => 'Description must be max 1000 characters.',
            'image.mimes'                   => 'Valid Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'background_image.mimes'        => 'Valid Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
        ];
    }
}
