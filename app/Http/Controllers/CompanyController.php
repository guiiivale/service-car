<?php

namespace App\Http\Controllers;

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

        $servicesData = [];
        foreach ($data['services'] as $serviceData) {
            $serviceId = $serviceData['id'];
            $value = $serviceData['value'];
            $duration = $serviceData['duration'];

            $servicesData[$serviceId] = [
                'value' => $value,
                'duration' => $duration,
            ];
        }

        $user->services()->sync($servicesData);

        return response()->json([
            'success' => true,
            'message' => 'Services selected successfully',
        ]);
    }
}
