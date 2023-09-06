<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserAppointmentsRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\User;
use App\Enums\Status;
use App\Models\Appointment;
use App\Models\Status as ModelsStatus;
use App\Models\UserActivityHistory;
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

        $status = ModelsStatus::find(Status::WAITING_PAYMENT_ID);

        $appointment = new Appointment([
            'scheduled_datetime' => $data['scheduled_datetime'],
            'notes' => $data['notes'],
        ]);
        $appointment->user()->associate($customer);
        $appointment->company()->associate($company);
        $appointment->vehicle()->associate($vehicle);
        $appointment->service()->associate($service);
        $appointment->status()->associate($status);
        $appointment->save();

        $activity = new UserActivityHistory();
        $activity->appointment()->associate($appointment);
        $activity->value = $service->pivot->value;
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ]);
    }

    public function userAppointments(GetUserAppointmentsRequest $request)
    {
        $customer = $request->customer;

        $appointments = $customer->userAppointments()->with(['company', 'vehicle', 'service', 'status', 'activity'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get user appointments success',
            'appointments' => $appointments,
        ]);
    }

    public function companyAppointments(Request $request)
    {
        $company  = $request->company;

        $appointments = $company->appointments()->with(['user', 'vehicle', 'service', 'status', 'activity'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get company appointments success',
            'appointments' => $appointments,
        ]);
    }
}
