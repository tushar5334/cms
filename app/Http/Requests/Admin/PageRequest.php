<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageRequest extends FormRequest
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
            'title' => 'required',
            'name' => 'required',
            'page_slug' => 'required|unique:pages,page_slug,' . $this->page_id . ',page_id,deleted_at,NULL',
            'meta_title' => 'sometimes',
            'meta_keywords' => 'sometimes',
            'meta_description' => 'sometimes',
            'page_id' => 'sometimes',
            'description' => 'sometimes',
            'page_header_image' => 'sometimes|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'page_slug.required' => 'The name field is required.',
            'page_slug.unique' => 'The name has already been taken.',
            'page_header_image.mimes' => 'Page header image field must be a file of type: jpg, jpeg, png',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['page_slug'] = Str::slug($data['name'], '-');
        $this->getInputSource()->replace($data);
        $validator = parent::getValidatorInstance();
        $validator->after(function ($validator) {
            $data = $this->all();
            $data['updated_by'] = Auth::guard('admin')->id();
            if ($data['page_id'] == '') {
                $data['created_by'] = Auth::guard('admin')->id();
            }
            $this->getInputSource()->replace($data);
        });
        return $validator;
    }
}
