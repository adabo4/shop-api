<?php

namespace App\Http\Requests;


use App\Enums\ProductType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateProductRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'ean' => ['sometimes', 'nullable', 'string', 'max:20'],
            'sukl_code' => ['sometimes', 'nullable', 'string', 'max:50'],
            'product_type' => ['sometimes', Rule::enum(ProductType::class)],
            'is_active' => ['boolean', 'sometimes'],
            'description' => ['sometimes', 'nullable', 'string'],
            'composition' => ['sometimes', 'nullable', 'string'],
            'dosage' => ['sometimes', 'nullable', 'string'],
            'usage' => ['sometimes', 'nullable', 'string'],
            'warnings' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
