<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'price.min' => 'Price must be a positive number greater than zero.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}