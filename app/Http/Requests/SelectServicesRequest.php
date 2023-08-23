<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SelectServicesRequest extends FormRequest
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
            'company_id' => 'required|exists:users,id',
            'services' => 'required|array',
            'services.*.id' => 'required|integer|exists:services,id',
            'services.*.value' => 'required|numeric',
            'services.*.duration' => 'required|integer',
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
            'user_id.required' => 'The user_id field is required',
            'services.required' => 'The services field is required',
            'services.array' => 'The services field must be an array',
            'value.required' => 'The values field is required',
            'value.decimal' => 'The values field must be decimal',
            'duration.required' => 'The duration field is required',
            'duration.integer' => 'The duration field must be integer',
        ];
    }
}
