<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'                    => ['required', 'string', 'max:255'],
            'last_name'                     => ['nullable', 'string', 'max:255'],
            // 'username'                      => ['required', 'string', 'max:255'],
            'email'                         => ['required', 'email', 'max:255', 'unique:users'],
            'phone'                         => ['required', 'string','unique:users'],
            'password'                      => ['required', 'confirmed', Password::defaults()],
            'accept_terms_and_conditions'   => ['required'],
        ];
    }
}
