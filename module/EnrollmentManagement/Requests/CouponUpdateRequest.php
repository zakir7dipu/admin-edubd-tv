<?php

namespace Module\EnrollmentManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
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

            'name'                     => ['required', 'min:2', 'max:255'],
            'code'                     => ['required', 'unique:em_coupons,code,'. $this->coupon->id],
            'start_date'               => ['required'],
            'end_date'                 => ['required'],

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
            'use_type.required'                => 'Use Type Should Be required.',
            'name.required'                    => 'Name Should Be required.',
            'name.min'                         => 'Name must be min 2 characters.',
            'name.max'                         => 'Name must be max 255 characters.',
            'code.required'                    => 'Code Should Be required.',
            'code.unique'                      => 'Code already exist!',
            'start_date.required'              => 'Start Date is required.',
            'start_date.required'              => 'Start Date is required.',
            'end_date.required'                => 'End Date is required.',
            'amount.required'                  => 'Discount Type is required.',
        ];
    }
}
