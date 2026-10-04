<?php

namespace App\Http\Requests;

use App\Enums\ProductType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'product_code' => ['required', 'string', 'max:50', 'unique:products,product_code'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'ean' => ['nullable', 'string', 'max:20', 'unique:products,ean'],
            'sukl_code' => ['nullable', 'string', 'max:50'],
            'product_type' => ['required', Rule::enum(ProductType::class)],
            'is_active' => ['boolean'],
            'description' => ['nullable', 'string'],
            'composition' => ['nullable', 'string'],
            'dosage' => ['nullable', 'string'],
            'usage' => ['nullable', 'string'],
            'warnings' => ['nullable', 'string'],
        ];
    }
}
