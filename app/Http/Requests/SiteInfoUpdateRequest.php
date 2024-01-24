<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteInfoUpdateRequest extends FormRequest
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

            'site_name' => ['required','min:2','max:50'],
            'site_title' => ['required', 'min:2','max:50'],
            'fav_icon' => ['nullable', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'logo' => ['nullable', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'transparent_logo' => ['nullable', 'mimes:jpg,bmp,png,jpeg,jfif,webp,gif'],
            'address' => ['required', 'min:2', 'max:500'],
            'phone' => ['required', 'min:2', 'max:13'],
            'email' => ['required'],


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
            'site_name.required' => 'Name is required.',
            'site_name.min' => 'Site Name must be min 2 characters.',
            'site_name.max' => 'Site Name must be max 50 characters.',
            'site_title.required' => 'Site Title is required.',
            'site_title.min' => 'Site Title must be min 2 characters.',
            'site_title.max' => 'Site Title must be max 50 characters.',
            'fav_icon.mimes' => 'Valid Fav Icon is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'logo.mimes' => 'Valid Logo is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'transparent_logo.mimes' => 'Valid Transparent Logo is required. (jpg, bmp, png, jpeg, jfif, webp, gif).',
            'address.required' => 'Address is required.',
            'address.min' => 'Address must be min 2 characters.',
            'address.max' => 'Address must be max 500 characters.',
            'phone.required' => 'phone is required',
            'phone.min' => 'Phone must be min 2 characters.',
            'phone.max' => 'Phone must be max 13 characters.',
            'email.required' => 'Email is required.',
        ];
    }
}
