<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantsRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'restaurant_name' => 'required',
            'restaurant_email' => 'required|email',
            'pdf' => 'mimes:pdf|max:10240',
            'hotel_id' => 'required',
            'active_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'restaurant_name.required' => 'Please insert restaurant name',
            'restaurant_email.required' => 'Please insert email address',
            'restaurant_email.email' => 'Invalid email address format',
            'pdf.mimes' => 'Invalid image type please choose type pdf',
            'pdf.max' => 'Maximum size 10 MB',
            //'pdf.regex' => 'Invalid PDF name, file name must be a-z and A-Z',
            'hotel_id.required' => 'Please select hotel',
            'active_id.required' => 'Please select restaurant status',
        ];
    }

}
