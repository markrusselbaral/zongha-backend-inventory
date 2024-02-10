<?php

namespace App\Http\Requests\Pricing;

use Illuminate\Foundation\Http\FormRequest;

class PricingRequest extends FormRequest
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
            'client_id' => 'required',
            'product_id' => 'required',
            'price' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'The client field is required.',
            'product_id.required' => 'The product field is required.',
            'price.required' => 'The price field is required.'
        ];
    }
}
