<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AddUserVehicleRequest extends FormRequest
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
            'type' => 'required|in:car,motorcycle,truck,bus,other',
            'model' => 'required|string',
            'make' => 'required|string',
            'year' => 'required|string',
            'color' => 'required|string',
            'plate' => 'required|string',
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
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'User ID does not exist',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be one of the following: car, motorcycle, truck, bus, other',
            'model.required' => 'Model is required',
            'model.string' => 'Model must be a string',
            'make.required' => 'Make is required',
            'make.string' => 'Make must be a string',
            'year.required' => 'Year is required',
            'year.string' => 'Year must be a string',
            'color.required' => 'Color is required',
            'color.string' => 'Color must be a string',
            'plate.required' => 'Plate is required',
            'plate.string' => 'Plate must be a string',
            'mileage.string' => 'Mileage must be a string',
            'fuel_type.string' => 'Fuel type must be a string',
        ];
    }

    public function getCustomer()
    {
        return $this->user();
    }
}
