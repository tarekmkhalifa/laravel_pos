<?php

namespace App\Http\Requests\dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
            'ar.name' => ['required', Rule::unique('category_translations', 'name')->ignore($this->category->id, 'category_id')],
            'en.name' => ['required', Rule::unique('category_translations', 'name')->ignore($this->category->id, 'category_id')],
        ];
    }
}
