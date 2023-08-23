<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'password' => 'required',
            'new_password' => 'required|string|min:8',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User id is required',
            'user_id.integer' => 'User id must be integer',
            'user_id.exists' => 'User id not found',
            'password.required' => 'Password is required',
            'new_password.required' => 'New password is required',
            'new_password.string' => 'New password must be string',
            'new_password.min' => 'New password must be at least 8 characters',
        ];
    }
}
