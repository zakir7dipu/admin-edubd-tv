<?php

namespace Module\WebsiteCMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
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
            'slug'                  => ['required', 'min:2', 'max:100'],
            'thumbnail_image'       => ['required', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'cover_image'           => [ 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'short_descriptiion'    => ['min:2', 'max:500'],
            'description'           => ['min:5'],
            'serial_no'             => ['required', 'numeric', 'unique:web_cms_blogs,serial_no'],
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
            'title.required'                => 'Blog Title is required.',
            'title.min'                     => 'Blog Title must be min 2 characters.',
            'title.max'                     => 'BLog Title must be max 255 characters.',
            'slug.required'                 => 'Slug Should be required',
            'slug.min'                      => 'Slug Must be Min 2 Characters',
            'slug.max'                      => 'Slug Must be Max 100 Characters',
            'thumbnail_image.required'      => 'Thumbnail Image is required.',
            'thumbnail_image.mimes'         => 'Valid Thumbnail Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'cover_image.mimes'             => 'Valid Cover Image is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'serial_no.required'            => 'Serial No is required.',
            'serial_no.numeric'             => 'Serial No must be a number.',
            'serial_no.unique'              => 'Serial No already exist!',
        ];
    }
}
