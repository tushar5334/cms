<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class InquiryRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'product_looking_for' => 'required',
            'end_use_application' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'additional_remark' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'phone.required' => 'Phone number field is required.',
            'email.required' => 'Email field is required.',
            'product_looking_for.required' => 'Product looking for field is required.',
            'end_use_application.required' => 'End use application field is required.',
            'company_name.required' => 'Company name field is required.',
            'company_address.required' => 'Company address field is required.',
            'additional_remark.required' => 'Additional remark field is required.',
        ];
    }
}
