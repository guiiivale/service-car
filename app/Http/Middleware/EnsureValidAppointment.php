<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidAppointment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = $request->customer;

        $company = $request->company;

        if(!$request->appointment_id)
            return response()->json([
                'success' => false,
                'message' => 'Appointment id is required',
            ], 400);

        $appointment = $customer->userAppointments()->find($request->appointment_id);

        if(!$appointment)
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);

        if($appointment->company_id != $company->id)

        return response()->json([
            'success' => false,
            'message' => 'Appointment not found',
        ], 404);

        $request->merge(['appointment' => $appointment]);

        return $next($request);
    }
}
