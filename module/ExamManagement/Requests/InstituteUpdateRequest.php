<?php

namespace Module\ExamManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstituteUpdateRequest extends FormRequest
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
            'name'            => ['required', 'min:2', 'max:255','unique_with:em_institutes,' . $this->institute->id],
            'short_form'      => [ 'min:2', 'max:20'],
            'address'         => [ 'max:500'],

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
            'name.required'         => 'Institute Name is required.',
            'name.min'              => 'Institute Name must be min 2 characters.',
            'name.max'              => 'Institue Name must be max 255 characters.',
            'name.unique_with'      => 'This Institute Name combination already exist',
            'short_form.min'        => 'Institue Short Form must be min 2 Characters',
            'short_form.max'        => 'Institue Short Form Should Not be max 20 Characters',
            'address.max'           =>'Institute Address Should not be max 500 characters',

        ];
    }
}
