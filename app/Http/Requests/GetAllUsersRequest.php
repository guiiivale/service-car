<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class GetAllUsersRequest extends FormRequest
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
            'type' => 'required|in:all,companies,users,service,company_categories',
            'company_category_id' => 'required_if:type,companies_categories|exists:company_categories,id',
            'service_id' => 'required_if:type,service|exists:services,id',
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
            'type.required' => 'The type field is required',
            'type.in' => 'The type field must be one of these: all, companies, users',
            'company_category_id.required_if' => 'The company_category_id field is required when type is companies',
            'company_category_id.exists' => 'The company_category_id field must be a valid company category id',
            'service_id.required_if' => 'The service_id field is required when type is service',
            'service_id.exists' => 'The service_id field must be a valid service id',
        ];
    }
}
