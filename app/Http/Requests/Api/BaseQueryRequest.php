<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Support\AuthContext;

abstract class BaseQueryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Inject defaults BEFORE validation
     */
    protected function prepareForValidation(): void
    {

        $tenantId = AuthContext::tenantId();
        $userId   = AuthContext::userId();
        $this->merge([
            'tenant_id'  => $tenantId,
            'user_id'    => $userId,
            'start_date' => $this->input('start_date') 
                            ?? now()->startOfMonth()->toDateString(),
            'term'    => $this->input('start_date') ?? null
        ]);
    }

    /**
     * Final rules = common + API specific
     */
    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            $this->specificRules()
        );
    }

    protected function commonRules(): array
    {
        return [
            'tenant_id'  => ['required', 'integer'],
            'user_id'    => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
            'page'       => ['nullable', 'integer', 'min:1'],
            'per_page'   => ['nullable', 'integer', 'min:1', 'max:100'],
            'search'     => ['nullable', 'string', 'max:255'],
        ];
    }

    abstract protected function specificRules(): array;

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
