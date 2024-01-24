<?php

namespace Module\WebsiteCMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberStoreRequest extends FormRequest
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
            'email' => ['required', 'min:2', 'max:255', 'email', 'unique:web_cms_subscribers,email'],
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
            'email.required'    => 'Email is Required',
            'email.min'         => 'Email must be min 2 characters.',
            'email.max'         => 'Email must be max 255 characters.',
            'email.email'       => 'Invalid Email.',
            'email.unique'      => 'Already Subscribed!',
        ];
    }
}
