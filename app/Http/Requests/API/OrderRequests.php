<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequests extends FormRequest
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
            'restaurant_name' => 'required|alpha_num|min:2|max:100',
            'delivery_time' => 'required|lte:60|gte:5',
            'customer_phone_number' => 'required|alpha_num|min:10|max:20'
        ];
    }
}
