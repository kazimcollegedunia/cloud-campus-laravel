<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount_inr' => 'nullable|numeric|min:1',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'status' => 'nullable|in:pending,paid,partial,failed',
            'remarks' => 'nullable|string',
            'meta' => 'nullable|array',
        ];
    }
}
