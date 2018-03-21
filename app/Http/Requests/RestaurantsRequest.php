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
            'hotel_id' => 'required',
            'active_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'restaurant_name.required' => 'Please insert restaurant name',
            'restaurant_email.required' => 'Please insert email address',
            'restaurant_email.email' => 'Invalid email address format',
            'hotel_id.required' => 'Please select hotel',
            'active_id.required' => 'Please select restaurant status',
        ];
    }

}
