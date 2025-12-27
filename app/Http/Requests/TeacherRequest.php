<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'phone' => 'required',
            'qualification' => 'required|string',
            'experience_years' => 'required|string',
            'joining_date' => [
                        'required',
                        'date',
                        Rule::date()->format('Y-m-d'),
                    ],
            'gender' => 'required|in:male,female,other',
            'dob' => [
                        'required',
                        'date',
                        Rule::date()->format('Y-m-d'),
                    ],
        ];
    }

    public function messages()
    {
        return [
            // 'tenant_id.required' => 'Select tet.',
            // 'user_id.exists' => 'The selected user id is invalid.',
            // 'class_id.required' => 'The class id field is required.',
            // 'section.required' => 'The section field is required.',
            // 'dob.required' => 'The date of birth field is required.',   
            // 'gender.required' => 'The gender field is required.',   
            // 'parent_name.required' => 'The parent name field is required.',   
            // 'parent_phone.required' => 'The parent contact No. field is required.',   
            // 'address.required' => 'The address field is required.',   
            // "parent_email.required" => "The parent_email field is required.",
            // "parent_email.unique" => "The parent_email  has already been taken.",
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
