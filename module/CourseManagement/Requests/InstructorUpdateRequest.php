<?php

namespace Module\CourseManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorUpdateRequest extends FormRequest
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'first_name'    => ['required', 'min:2', 'max:255'],
            'last_name'     => ['nullable', 'min:2', 'max:255'],
            'username'      => ['nullable', 'min:2', 'max:255', 'unique:users,username,' . $this->instructor->id, 'regex:/\w*$/'],
            'phone'         => ['required', 'unique:users,phone,' . $this->instructor->id],
            'gender'        => ['required'],
            'bio'           => ['nullable', 'min:2', 'max:500'],
            'experience'    => ['nullable', 'min:2', 'max:300'],
            // 'country_id'    => ['required'],
            // 'city_id'       => ['required'],
            'address_1'     => ['required'],
            'postcode'      => ['required'],
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
            'phone.required'        => 'Phone is required.',
            'phone.unique'          => 'Phone already exist!',
            'gender.required'       => 'Gender is required.',
            'bio.min'               => 'Bio must be min 2 characters.',
            'bio.max'               => 'Bio must be max 500 characters.',
            'experience.min'        => 'Experience must be min 2 characters.',
            'experience.max'        => 'Experience must be max 300 characters.',
            'country_id.required'   => 'Country is required.',
            'city.required'         => 'City is required.',
            'address_1.required'    => 'Street Address 1 is required.',
            'postcode.required'     => 'Postcode is required.',
            'image.mimes'           => 'Invalid image type. You can use (jpeg, jpg, png, gif, webp) type.',
        ];
    }
}
