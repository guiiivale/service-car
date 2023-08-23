<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidVehicle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = $request->customer;

        if(!$request->vehicle_id) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle id is required',
            ], 400);
        }

        $vehicle = $customer->vehicles()->find($request->vehicle_id);

        if(!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

        $request->merge(['vehicle' => $vehicle]);

        return $next($request);
    }
}
