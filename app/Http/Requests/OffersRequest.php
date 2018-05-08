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
            'offer_name_en' => 'required',
            'attachments' => 'mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'offer_date_start' => 'required',
            'offer_date_end' => 'required',
            /*'offer_lunch_price' => 'integer',
            'offer_lunch_guest' => 'integer|between:0,10000',
            'offer_dinner_price' => 'integer',
            'offer_dinner_guest' => 'integer|between:0,10000',*/
            'offer_comment_en' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'offer_name_en.required' => 'Please insert default offer name',
            //'image.required' => 'Image is not upload',
            'attachments.mimes' => 'Invalid image type please choose type jpeg, png, jpg, gif, pdf',
            'attachments.max' => 'Maximum size 2 MB',
            'offer_date_start.required' => 'Please select date start',
            'offer_date_end.required' => 'Please select date end',
            /*'offer_lunch_price.between' => 'Please insert integer  0 to 1000000',
            'offer_lunch_guest.integer' => 'Please insert max guest is integer',
            'offer_lunch_guest.between' => 'Please insert integer  0 to 10000',
            'offer_dinner_price.between' => 'Please insert integer  0 to 1000000',
            'offer_dinner_guest.integer' => 'Please insert max guest is integer',
            'offer_dinner_guest.between' => 'Please insert integer  0 to 10000',*/
            'offer_comment_en.required' => 'Please insert default offer description',
        ];
    }
}
