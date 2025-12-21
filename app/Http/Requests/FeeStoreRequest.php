<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FeeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'student_id'    => 'required|integer|exists:students,id',
            'fee_type_id'   => 'required|integer|exists:fee_types,id',
            'paid_amount'    => 'required|numeric|min:1',
            'due_date'      => 'nullable|date',
            'remarks'       => 'nullable|string',
            'meta'          => 'nullable|array'
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
