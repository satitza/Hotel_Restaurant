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
            'hotel_id' => 'required',
            'active_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'restaurant_name.required' => 'กรุณากรอกชื่อร้านอาหาร',
            'hotel_id.required' => 'กรุณาเลือกโรงแรม',
            'active_id.required' => 'กรุณาเลือกสถานะร้านอาหาร',
        ];
    }

}
