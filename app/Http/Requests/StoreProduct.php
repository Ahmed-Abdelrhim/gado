<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'card_image'         =>'nullable|mimes:jpeg,png,jpg,gif',
            'name_ar'            =>'required|max:190|min:5|string',
            'name_en'            =>'required|max:190|min:5|string',
            'price'              =>'required',
            'price_discount'     =>'required',
            'dealer_price'       =>'required',
            'categories'         =>'required|array',
            'galary.*'           =>'required|mimes:jpeg,png,jpg,gif',
            'des_ar'             =>'required',
            'des_en'             =>'required',
        ];
    }
}
