<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
            'token' => 'required|string|exists:users,reset_password_token',
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
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.exists' => 'Email does not exist',
            'new_password.required' => 'New password is required',
            'new_password.string' => 'New password must be a string',
            'new_password.min' => 'New password must be at least 8 characters',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.string' => 'Confirm password must be a string',
            'confirm_password.min' => 'Confirm password must be at least 8 characters',
            'confirm_password.same' => 'Confirm password must be the same as new password',
            'email.required' => 'Token is required',
            'email.exists' => 'Token does not exist',
        ];
    }
}
