<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
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
        $user_id = $this->user_id != '' ? $this->user_id : 'NULL';
        $data = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id . ',user_id,deleted_at,NULL',
            'password' => 'nullable|min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'nullable|min:5',
            'profile_picture' => 'sometimes|mimes:jpg,jpeg,png',
            'user_id' => 'sometimes',
            'isImgDel' => 'sometimes',
        );
        return $data;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'email.unique' => 'Email has already been taken.',
            'email.required' => 'Email field is required.',
            //'password.required' => 'Password Field is required.',
            //'confirm_password.required' => 'Confirm password field is required.',
            'profile_picture.mimes' => 'Profile picture field must be a file of type: jpg, jpeg, png',
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        return $validator;
        /* $validator = parent::getValidatorInstance();
        $validator->after(function ($validator) {
            $data = $this->all();
            $data['updated_by'] = Auth::guard('admin')->id();
            if ($data['user_id'] == '') {
                $data['created_by'] = Auth::guard('admin')->id();
            }
            $data['user_type'] = "User";
            $this->getInputSource()->replace($data);
        });
        return $validator; */
    }
}
