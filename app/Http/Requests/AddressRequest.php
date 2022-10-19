<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "customer_id" => "required|numeric",
            "address" => "required|string",
            "ward_id" => "required|numeric",
            "district_id" => "required|numeric",
            "province_id" => "required|numeric",
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'customer id is required!',
            'customer_id.numeric' => 'customer id must be number type!',
            'address.required' => 'address is required!',
            'address.string' => 'address must be string type',
            'ward_id.required' => 'ward id is required!',
            'ward_id.string' => 'ward id must be number type!',
            'district_id.required' => 'district id is required!',
            'district_id.numeric' => 'district id must be number type!',
            'province_id.required' => 'province id is required!',
            'province_id.numeric' => 'province id must be number type!',
        ];
    }
}
