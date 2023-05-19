<?php

namespace App\Http\Requests\dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'ar.name' => ['required','unique:product_translations,name'],
            'ar.description' => ['required','unique:product_translations,description'],
            'en.name' => ['required','unique:product_translations,name'],
            'en.description' => ['required','unique:product_translations,description'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ];
    }
}
