<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRequest extends FormRequest
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
            'class_id' => 'required|integer',
            'section' => 'required|string',
            'parent_email' => 'required|string|unique:users,email',
            // 'roll_number' => 'required|string|unique:employees,roll_number',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:15',
            'address' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Please Select a User.',
            'user_id.exists' => 'The selected user id is invalid.',
            'class_id.required' => 'The class id field is required.',
            'section.required' => 'The section field is required.',
            'dob.required' => 'The date of birth field is required.',   
            'gender.required' => 'The gender field is required.',   
            'parent_name.required' => 'The parent name field is required.',   
            'parent_phone.required' => 'The parent contact No. field is required.',   
            'address.required' => 'The address field is required.',   
            "parent_email.required" => "The parent_email field is required.",
            "parent_email.unique" => "The parent_email  has already been taken.",
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
