<?php

namespace Module\UserAccess\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'username'      => ['nullable', 'min:2', 'max:255', 'unique:users,username', 'regex:/\w*$/'],
            'email'         => ['required', 'min:2', 'max:255', 'unique:users,email'],
            'password'      => ['required'],
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
            'username.min'          => 'Username must be min 2 characters.',
            'username.max'          => 'Username must be max 255 characters.',
            'username.unique'       => 'Username already exist!',
            'username.regex'        => 'Username format is invalid!',
            'email.required'        => 'Email is required.',
            'email.min'             => 'Email must be min 2 characters.',
            'email.max'             => 'Email must be max 255 characters.',
            'email.unique'          => 'Email already exist!',
            'password.required'     => 'Password is required.',
            'image.mimes'           => 'Invalid image type. You can use (jpeg, jpg, png, gif, webp) type.',
        ];
    }
}
