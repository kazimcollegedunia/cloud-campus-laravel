<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',

            // OPTIONAL CONTACT NUMBERS
            'contact_numbers' => 'nullable|array',
            'contact_numbers.*.number' => 'required_with:contact_numbers|string',
            'contact_numbers.*.type' => 'nullable|string',

            // OPTIONAL ADDRESSES
            'addresses' => 'nullable|array',
            'addresses.*.address_line' => 'required_with:addresses|string',
            'addresses.*.city' => 'required_with:addresses|string',
            'addresses.*.state' => 'required_with:addresses|string',
            'addresses.*.country' => 'required_with:addresses|string',
            'addresses.*.pincode' => 'required_with:addresses|string',
        ];
    }
}
