<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'adress' => 'required',
            'city' => 'required',
            'region' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'status' => 'required',
            'categories_id' => 'required',
            'user_id' => 'required',
            'house_details_id' => 'required',
            'location_id' => 'required'
        ];
    }
}
