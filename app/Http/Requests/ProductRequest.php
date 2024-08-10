<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_code' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|integer',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Customize the error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_code.required' => 'The product code is required.',
            'product_code.unique' => 'The product code must be unique.',
            'name.required' => 'The product name is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'category_id.required' => 'The category is required.',
            'brand_id.required' => 'The brand is required.',
            'stock.required' => 'The stock quantity is required.',
            'stock.integer' => 'The stock quantity must be an integer.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
