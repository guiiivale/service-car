<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserAppointmentsRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        $customer = $request->customer;

        $company = $request->company;

        $vehicle = $request->vehicle;

        $service = $request->service;
    }

    public function userAppointments(GetUserAppointmentsRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['user_id']);

        if(!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $appointments = $user->userAppointments()->get();
    }
}
