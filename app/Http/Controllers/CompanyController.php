<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditServicesRequest;
use App\Http\Requests\RemoveServicesRequest;
use App\Http\Requests\SelectServicesRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserTypes;

class CompanyController extends Controller
{
    public function selectServices(SelectServicesRequest $request)
    {
        $data = $request->validated();

        $company = $request->company;

        $existingServices = $company->services->pluck('id')->toArray();
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

        $company->services()->sync($servicesToSync);

        return response()->json([
            'success' => true,
            'message' => 'Services edited successfully',
        ]);
    }

    public function removeServices(RemoveServicesRequest $request) 
    {
        $data = $request->validated();

        $company = $request->company;

        $company->services()->detach($data['services']);

        return response()->json([
            'success' => true,
            'message' => 'Services removed successfully',
        ]);
    }
}
