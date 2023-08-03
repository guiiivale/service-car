<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'user_type_id' => 'required|exists:user_types,id',
            'company_category_id' => 'required_if:user_type_id,1|exists:company_categories,id',
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
            'email.required' => 'The email field is required',
            'password.required' => 'The password field is required',
            'email.email' => 'The email field must be a valid email address',
            'password_confirmation.required' => 'The password confirmation field is required',
            'password_confirmation.same' => 'The password confirmation field must match the password field',
            'name.required' => 'The name field is required',
            'user_type_id.required' => 'The user type field is required',
            'user_type_id.exists' => 'The selected user type is invalid',
            'company_category_id.required_if' => 'The company category field is required',
            'company_category_id.exists' => 'The selected company category is invalid',
        ];
    }
}
