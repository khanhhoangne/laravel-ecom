<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCommentRequest extends FormRequest
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
            "blog_id" => "required|numeric",
            'customer_id' => 'required|numeric',
            'content' => 'required|string',
            'parent_id' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'blog_id.required' => 'blog id is required!',
            'blog_id.numeric' => 'blog_id must be number type!',
            'customer_id.required' => 'customer id is required!',
            'customer_id.numeric' => 'customer must be number type',
            'content.required' => 'content is required!',
            'content.string' => 'string must be string type!',
            'parent_id.numeric' => 'parent id must be number type!',
        ];
    }
}
