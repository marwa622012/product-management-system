<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
        
        'type'        => 'required|in:simple,variable',
        'name'        => 'required|array',
        'name.ar'     => 'required|string|max:255',
        'name.en'     => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description'=> 'nullable|string',
        'is_active'   => 'required|boolean',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5048',
        'sku'   => 'required|string|max:255|unique:products,sku',
        'price' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ];
    }
    
}
