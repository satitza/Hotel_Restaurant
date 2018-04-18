<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImagesRequest extends FormRequest
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
            'images' => 'mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'images.mimes' => 'Invalid image type please choose type jpeg, png, jpg, gif',
            'images.max' => 'Maximum size 2 MB',

        ];
    }
}
