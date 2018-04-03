<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
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
            'offer_date_start' => 'required',
            'offer_date_end' => 'required',
            'offer_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|between:1,100000',
            'offer_guest' => 'required|integer|between:1,10000',
        ];
    }

    public function messages()
    {
        return [
            //'menu_name.required' => 'Please insert menu name',
            //'image.required' => 'Image is not upload',
            'image.mimes' => 'Invalid image type please choose type jpeg, png, jpg, gif',
            'image.max' => 'Maximum size 2 MB',
            'offer_date_start.required' => 'Please select date start',
            'offer_date_end.required' => 'Please select date end',
            'offer_price.required' => 'Please insert price',
            'offer_price.regex' => 'Price is request 2 decimal places',
            'offer_price.between' => 'Please insert integer  1 to 1000000',
            'offer_guest.required' => 'Please insert max guest',
            'offer_guest.integer' => 'Please insert max guest is integer',
            'offer_guest.between' => 'Please insert integer  1 to 10000',
        ];
    }
}
