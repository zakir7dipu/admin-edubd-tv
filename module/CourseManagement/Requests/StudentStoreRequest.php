<?php

namespace Module\CourseManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'first_name'    => ['required', 'min:2', 'max:255'],
            'last_name'     => ['nullable', 'min:2', 'max:255'],
            'username'      => ['nullable', 'min:2', 'max:255', 'regex:/\w*$/'],
            'email'         => ['required', 'min:2', 'max:255', 'unique:users,email'],
            'phone'         => ['required', 'unique:users,phone'],
            'gender'        => ['required'],
            'bio'           => ['nullable', 'min:2', 'max:500'],
            'country_id'    => ['required'],
            'city_id'       => ['required'],
            'address_1'     => ['required'],
            'postcode'      => ['required'],
            // 'password'      => ['required'],
            'image'         => ['nullable', 'mimes:jpeg,jpg,png,gif,webp'],
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
            'first_name.required'   => 'First Name is required.',
            'first_name.min'        => 'First Name must be min 2 characters.',
            'first_name.max'        => 'First Name must be max 255 characters.',
            'last_name.min'         => 'Last Name must be min 2 characters.',
            'last_name.max'         => 'Last Name must be max 255 characters.',
            'username.min'          => 'Username must be min 2 characters.',
            'username.max'          => 'Username must be max 255 characters.',
            'username.unique'       => 'Username already exist!',
            'username.regex'        => 'Username format is invalid!',
            'email.required'        => 'Email is required.',
            'email.min'             => 'Email must be min 2 characters.',
            'email.max'             => 'Email must be max 255 characters.',
            'email.unique'          => 'Email already exist!',
            'phone.required'        => 'Phone is required.',
            'phone.unique'          => 'Phone already exist!',
            'gender.required'       => 'Gender is required.',
            'bio.min'               => 'Bio must be min 2 characters.',
            'bio.max'               => 'Bio must be max 500 characters.',
            'country_id.required'   => 'Country is required.',
            'city.required'         => 'City is required.',
            'address_1.required'    => 'Street Address 1 is required.',
            'postcode.required'     => 'Postcode is required.',
            // 'password.required'     => 'Password is required.',
            'image.mimes'           => 'Invalid image type. You can use (jpeg, jpg, png, gif, webp) type.',
        ];
    }
}
