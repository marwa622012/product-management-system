<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku'         => 'required|string|max:255|unique:products,sku',
        'name'        => 'required|array',
        'name.ar'     => 'required|string|max:255',
        'name.en'     => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description'=> 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'is_active'   => 'required|boolean',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'stock'       => 'required|integer|min:0',
        'type'        => 'required|in:simple,variable',
        ];
    }
}
