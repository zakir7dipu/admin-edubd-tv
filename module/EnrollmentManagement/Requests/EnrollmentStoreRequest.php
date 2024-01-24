<?php

namespace Module\EnrollmentManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentStoreRequest extends FormRequest
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
            // 'payment_method_id' => ['nullable'],
            'course_id.*'       => ['required'],
            'regular_fee.*'     => ['required'],
            'course_fee.*'      => ['required'],
            'quantity.*'        => ['required'],
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
            // 'payment_method_id.required'    => 'Payment Method is required.',
            'course_id.*.required'          => 'Course is required.',
            'regular_fee.*.required'        => 'Regular Fee is required.',
            'course_fee.*.required'         => 'Course Fee is required.',
            'quantity.*.required'           => 'Quantity is required.',
        ];
    }
}
