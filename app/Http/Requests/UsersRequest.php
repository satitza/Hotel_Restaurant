<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required|min:8',
        ];
    }

    public function messages() {
        return [
            'user_name.required' => 'กรุณากรอก User name',
            'user_email.required' => 'กรุณากรอก Email',
            'user_email.email' => 'กรูณากรอก Email ให้ถูกต้อง',
            'user_password.required' => 'กรูณากรอก Password',
            'user_password.min' => 'กรุณากรอก Password อย่างน้อย 8 ตัวอักษร'
        ];
    }
}
