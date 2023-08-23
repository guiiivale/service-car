<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class EditUserVehicleRequest extends FormRequest
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'type' => 'nullable|in:car,motorcycle,truck,bus,other',
            'model' => 'nullable|string',
            'make' => 'nullable|string',
            'year' => 'nullable|string',
            'color' => 'nullable|string',
            'new_plate' => 'nullable|string',
            'mileage' => 'nullable|string',
            'fuel_type' => 'nullable|string',
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
            'user_id.exists' => 'User id does not exist',
            'type.in' => 'Type must be one of the following: car, motorcycle, truck, bus, other',
            'vehicle_id.required' => 'Vehicle id is required',
            'vehicle_id.exists' => 'Vehicle id does not exist',
        ];
    }
}
