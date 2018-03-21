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
            'user_name.required' => 'Please insert username',
            'user_email.required' => 'Please insert email address',
            'user_email.email' => 'Invalid email address format',
            'user_password.required' => 'Please insert password',
            'user_password.min' => 'Password is request min 8 character'
        ];
    }
}
