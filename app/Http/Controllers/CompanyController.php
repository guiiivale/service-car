<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditServicesRequest;
use App\Http\Requests\RemoveServicesRequest;
use App\Http\Requests\SelectServicesRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function selectServices(SelectServicesRequest $request)
    {
        $data = $request->validated();
        $user = User::find($data['user_id']);

        if (!$user || $user->user_type_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a company',
            ], 400);
        }

        $existingServices = $user->services->pluck('id')->toArray();
        $servicesToSync = [];

        foreach ($data['services'] as $serviceData) {
            $serviceId = $serviceData['id'];
            $value = $serviceData['value'];
            $duration = $serviceData['duration'];

            if (in_array($serviceId, $existingServices)) {
                $servicesToSync[$serviceId] = [
                    'value' => $value,
                    'duration' => $duration,
                ];
                continue;
            }

            $servicesToSync[$serviceId] = [
                'value' => $value,
                'duration' => $duration,
            ];
        }

        $user->services()->sync($servicesToSync);

        return response()->json([
            'success' => true,
            'message' => 'Services edited successfully',
        ]);
    }

    public function removeServices(RemoveServicesRequest $request) 
    {
        $data = $request->validated();

        $user = User::find($data['user_id']);

        if (!$user || $user->user_type_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a company',
            ], 400);
        }

        $user->services()->detach($data['services']);

        return response()->json([
            'success' => true,
            'message' => 'Services removed successfully',
        ]);
    }
}
