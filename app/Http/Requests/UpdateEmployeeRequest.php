<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        // Works for both {id} or {employee}
        $id = $this->route('employee') ?? $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:employees,email,{$id}",
            'department_id' => 'required|exists:departments,id',
        ];
    }
}
