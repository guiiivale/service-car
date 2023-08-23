<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserAppointmentsRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\User;
use App\Enums\Status;
use App\Models\Appointment;
use App\Models\Status as ModelsStatus;
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

        $appointment = Appointment::create([
            'scheduled_datetime' => $data['scheduled_datetime'],
            'notes' => $data['notes'],
        ]);

        $status = ModelsStatus::find(Status::WAITING_PAYMENT_ID);
        
        $appointment->user()->associate($customer);
        $appointment->company()->associate($company);
        $appointment->vehicle()->associate($vehicle);
        $appointment->service()->associate($service);
        $appointment->status()->associate($status);
        
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ]);
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
