<?php

namespace App\Http\Requests\dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'ar.name' => ['required', Rule::unique('product_translations', 'name')->ignore($this->product->id, 'product_id')],
            'en.name' => ['required', Rule::unique('product_translations', 'name')->ignore($this->product->id, 'product_id')],
            'ar.description' => ['required', Rule::unique('product_translations', 'description')->ignore($this->product->id, 'product_id')],
            'en.description' => ['required', Rule::unique('product_translations', 'description')->ignore($this->product->id, 'product_id')],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ];
    }
}
