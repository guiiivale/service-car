<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class StoreAppointmentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'scheduled_datetime' => 'required|date_format:Y-m-d H:i:s',
            'notes' => 'nullable|string',
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
            'user_id.required' => 'User is required',
            'user_id.exists' => 'User does not exist',
            'company_id.required' => 'Company is required',
            'company_id.exists' => 'Company does not exist',
            'service_id.required' => 'Service is required',
            'service_id.exists' => 'Service does not exist',
            'vehicle_id.required' => 'Vehicle is required',
            'vehicle_id.exists' => 'Vehicle does not exist',
            'scheduled_datetime.required' => 'Scheduled date and time is required',
            'scheduled_datetime.datetime' => 'Scheduled date and time is not valid',
            'notes.string' => 'Notes must be a string',
        ];
    }
}
