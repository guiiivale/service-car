<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function getAll()
    {
        $services = Service::with('category')->get();

        if($services->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Services not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get all services success',
            'services' => $services,
        ]);
    }

    public function get(GetServiceRequest $request)
    { 
        $data = $request->validated();

        $service = Service::with('category')->find($data['id']);

        if(!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get service success',
            'service' => $service,
        ]);
    }
}
