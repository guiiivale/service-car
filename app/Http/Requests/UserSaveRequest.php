<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserSaveRequest extends FormRequest
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
            'id' => 'required|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|unique:users,email',
            'description' => 'nullable',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|array',
            'address.id' => 'nullable|exists:addresses,id',
            'address.street' => 'required_if:address,*|string',
            'address.number' => 'required_if:address,*|string|max:10',
            'address.complement' => 'nullable|string',
            'address.zipcode' => 'required_if:address,*|string|max:8',
            'address.city' => 'required_if:address,*|string',
            'address.state' => 'required_if:address,*|string|max:2',
            'address.is_main' => 'required|boolean',
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
            'id.required' => 'The id field is required',
            'id.exists' => 'The id field must be exists',
            'name.string' => 'The name field must be string',
            'name.max' => 'The name field must be max 255 characters',
            'email.unique' => 'The email field must be unique',
            'email.string' => 'The email field must be string',
            'email.max' => 'The email field must be max 255 characters',
            'phone.string' => 'The phone field must be string',
            'phone.max' => 'The phone field must be max 255 characters',
            'address.array' => 'The address field must be array',
            'address.*.id.exists' => 'The address.*.id field must be exists',
            'address.*.street.required_if' => 'The address.*.street field is required',
            'address.*.street.string' => 'The address.*.street field must be string',
            'address.*.number.required_if' => 'The address.*.number field is required',
            'address.*.number.string' => 'The address.*.number field must be string',
            'address.*.number.max' => 'The address.*.number field must be max 10 characters',
            'address.*.complement.string' => 'The address.*.complement field must be string',
            'address.*.zipcode.required_if' => 'The address.*.zipcode field is required',
            'address.*.zipcode.string' => 'The address.*.zipcode field must be string',
            'address.*.zipcode.max' => 'The address.*.zipcode field must be max 8 characters',
            'address.*.city.required_if' => 'The address.*.city field is required',
            'address.*.city.string' => 'The address.*.city field must be string',
            'address.*.state.required_if' => 'The address.*.state field is required',
            'address.*.state.string' => 'The address.*.state field must be string',
            'address.*.state.max' => 'The address.*.state field must be max 2 characters',
            'address.*.is_main.required' => 'The address.*.is_main field is required',
            'address.*.is_main.boolean' => 'The address.*.is_main field must be boolean',
        ];
    }
}
