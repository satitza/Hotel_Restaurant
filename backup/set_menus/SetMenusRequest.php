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
            //'menu_name' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'menu_date_start' => 'required',
            'menu_date_end' => 'required',
            'menu_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|between:1,100000',
            'menu_guest' => 'required|integer|between:1,10000',
        ];
    }

    public function messages() {
        return [
            //'menu_name.required' => 'Please insert menu name',
            //'image.required' => 'Image is not upload',
            'image.mimes' => 'Invalid image type please choose type jpeg, png, jpg, gif',
            'image.max' => 'Maximum size 2 MB',
            'menu_date_start.required' => 'Please select date start',
            'menu_date_end.required' => 'Please select date end',
            'menu_price.required' => 'Please insert price',
            'menu_price.regex' => 'Price is request 2 decimal places',
            'menu_price.between' => 'Please insert integer  1 to 1000000',
            'menu_guest.required' => 'Please insert max guest',
            'menu_guest.integer' => 'Please insert max guest is integer',
            'menu_guest.between' => 'Please insert integer  1 to 10000',
        ];
    }
}
