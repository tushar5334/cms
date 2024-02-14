<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderImageRequest extends FormRequest
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
        $slider_id = $this->slider_id != '' ? $this->slider_id : 'NULL';
        return [
            'title' =>
            'required|unique:slider_images,title,' . $slider_id . ',slider_id,deleted_at,NULL',
            'slider_id' => 'sometimes',
            'description' => 'sometimes',
            'slider_image' => 'sometimes|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'slider_image.mimes' => 'Slider image field must be a file of type: jpg, jpeg, png',
        ];
    }
}
