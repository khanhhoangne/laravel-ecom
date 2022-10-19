<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "fullname" => "required|max:255",
            'email' => 'required|email|unique:shop_customers',
            'phone' => 'required|unique:shop_customers|regex:/^[0-9]{10}+$/',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Fullname is required!',
            'fullname.max' => 'Fullname is too long!',
            'phone.required' => 'Phone is required!',
            'phone.unique' => 'This phone is exist',
            'phone.regex' => 'Phone is wrong format!',
            'email.required' => 'Email is required!',
            'email.email' => 'Email is wrong format!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password is too short',
            'email.unique' => 'This email account is exist',
        ];
    }
}
