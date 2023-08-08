<?php

namespace App\Http\Controllers;

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

        $user = User::find($data['user_id']);
        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }
        
        if($user->user_type_id != 2) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a customer',
            ], 400);
        }

        if($user->vehicles()->where('plate', $data['plate'])->first()) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle with this plate already exists',
            ], 400);
        }

        $vehicle = $user->vehicles()->create([
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

        $user = User::find($data['user_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ($user->user_type_id != 2) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a customer',
            ], 400);
        }

        $vehicle = $user->vehicles()->where('plate', $data['plate'])->first();
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

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
        $data = $request->validated();

        $user = User::find($data['user_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ($user->user_type_id != 2) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a customer',
            ], 400);
        }

        $vehicle = $user->vehicles()->where('plate', $data['plate'])->first();
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully',
        ]);
    }

}
