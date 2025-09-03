<?php

namespace App\Http\Requests\Api\Movil;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSaleRequest extends FormRequest
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
            'type_voucher' => 'required|string',
            'type_document' => 'required|string',
            'n_document' => 'required|integer|digits_between:8,11',
            'names' => 'nullable|string|min:3|max:50',
            'razon_social' => ['nullable','string', 'min:3', 'max:80'],
            'dirección fiscal' => ['nullable', 'string', 'min:3', 'max:150'],
            'type_emision' => 'required|string|max:20',
            'methd_payment' => 'required|max:15',
            'paid_amount' => 'required|decimal:2',
        ];
    }
}
