<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ClassRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (auth()->check()) {
            $this->merge([
                'tenant_id' => auth()->user()->tenant_id,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'class'     => 'required|string',
            'tenant_id' => 'required|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
