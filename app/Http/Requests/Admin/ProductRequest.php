<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $product_id = $this->product_id != '' ? $this->product_id : 'NULL';
        return [
            'product_name' =>
            'required|unique:products,product_name,' . $product_id . ',product_id,deleted_at,NULL',
            //'principal' => 'required',
            //'country' => 'required',
            //'product_segments' => 'required|array',
            //'product_categories' => 'required|array',
            'product_companies' => 'required|array',

        ];
    }

    public function messages()
    {
        return [
            //'product_segments.required' => 'The Segment field is required.',
            //'product_categories.required' => 'The Category field is required.',
            'product_companies.required' => 'The Company field is required.',
        ];
    }
}
