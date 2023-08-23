<?php

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Http\Requests\AddUserVehicleRequest;
use App\Http\Requests\EditUserVehicleRequest;
use App\Http\Requests\RemoveUserVehicleRequest;
use App\Models\User;

use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function add(AddUserVehicleRequest $request)
    {
        $data = $request->validated();

        $customer = $request->customer;

        if($customer->vehicles()->where('plate', $data['plate'])->first()) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle with this plate already exists',
            ], 400);
        }

        $vehicle = $customer->vehicles()->create([
            'type' => $data['type'],
            'model' => $data['model'],
            'make' => $data['make'],
            'year' => $data['year'],
            'color' => $data['color'],
            'plate' => $data['plate'],
            'mileage' => $data['mileage'] ?? null,
            'fuel_type' => $data['fuel_type'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Add vehicle success',
            'vehicle' => $vehicle,
        ]);
    }

    public function edit(EditUserVehicleRequest $request)
    {
        $data = $request->validated();

        $vehicle = $request->vehicle;

        $vehicle->update([
            'type' => $data['type'] ?? $vehicle->type,
            'model' => $data['model'] ?? $vehicle->model,
            'make' => $data['make'] ?? $vehicle->make,
            'year' => $data['year'] ?? $vehicle->year,
            'color' => $data['color'] ?? $vehicle->color,
            'plate' => $data['new_plate'] ?? $vehicle->plate,
            'mileage' => $data['mileage'] ?? $vehicle->mileage,
            'fuel_type' => $data['fuel_type'] ?? $vehicle->fuel_type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully',
            'vehicle' => $vehicle,
        ]);
    }

    public function remove(RemoveUserVehicleRequest $request)
    {
        $vehicle = $request->vehicle;

        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully',
        ]);
    }

    public function getAll(Request $request)
    {
        $customer = $request->user;

        $vehicles = $customer->vehicles()->get();

        return response()->json([
            'success' => true,
            'message' => 'Get vehicles success',
            'vehicles' => $vehicles,
        ]);
    }

    public function get(Request $request)
    {
        $vehicle = $request->vehicle;

        return response()->json([
            'success' => true,
            'message' => 'Get vehicle success',
            'vehicle' => $vehicle,
        ]);
    }
}
