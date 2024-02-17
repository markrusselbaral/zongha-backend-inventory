<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'date' => 'required',
            'product_id' => 'required',
            'client_id' => '',
            'type' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'status' => 'required',
            'mode_of_payment' => 'required',
        ];
    }
}
