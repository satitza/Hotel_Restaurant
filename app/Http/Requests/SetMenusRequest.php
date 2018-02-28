<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetMenusRequest extends FormRequest
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
            'menu_name' => 'required',
            'menu_date_start' => 'required',
            'menu_date_end' => 'required',
            'menu_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|between:1,100000',
            'menu_guest' => 'required|integer|between:1,10000',
        ];
    }

    public function messages() {
        return [
            'menu_name.required' => 'กรุณากรอกชื่อเมนู',
            'menu_date_start.required' => 'กรุณากรอกวันที่เริ่ม',
            'menu_date_end.required' => 'กรุณากรอกวันที่สิ้นสุด',
            'menu_price.required' => 'กรุณากรอกราคาต่อคน',
            'menu_price.regex' => 'กรุณากรอกราคาต่อคนเป็นตัวเลขทศนิยม 2 ตำแหน่ง 00.00',
            'menu_price.between' => 'กรุณากรอกเป็นตัวเลข 1 ถึง 1000000',
            'menu_guest.required' => 'กรุณากรอกจำนวนคนต่อวัน',
            'menu_guest.integer' => 'กรุณากรอกจำนวนคนต่อวันเป็นตัวเลข',
            'menu_guest.between' => 'กรุณากรอกจำนวนคนต่อวันเป็นตัวเลข 1 ถึง 10000',
        ];
    }
}
