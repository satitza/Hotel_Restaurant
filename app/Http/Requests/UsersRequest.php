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
            'user_password' => 'required',
        ];
    }

    public function messages() {
        return [
            'user_name.required' => 'กรุณากรอก User name',
            'user_email.required' => 'กรุณากรอก Email',
            'user_email.email' => 'กรูณากรอก Email ให้ถูกต้อง',
            'user_password.required' => 'กรูณากรอก Password'


            /*'menu_name.required' => 'กรุณากรอกชื่อเมนู',
            'menu_date_start.required' => 'กรุณากรอกวันที่เริ่ม',
            'menu_date_end.required' => 'กรุณากรอกวันที่สิ้นสุด',
            'menu_price.required' => 'กรุณากรอกราคาต่อคน',
            'menu_price.regex' => 'กรุณากรอกราคาต่อคนเป็นตัวเลขทศนิยม 2 ตำแหน่ง 00.00',
            'menu_price.between' => 'กรุณากรอกเป็นตัวเลข 1 ถึง 1000000',
            'menu_guest.required' => 'กรุณากรอกจำนวนคนต่อวัน',
            'menu_guest.integer' => 'กรุณากรอกจำนวนคนต่อวันเป็นตัวเลข',
            'menu_guest.between' => 'กรุณากรอกจำนวนคนต่อวันเป็นตัวเลข 1 ถึง 10000',*/
        ];
    }
}
