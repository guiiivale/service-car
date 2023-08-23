<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->company;

        if(!$request->service_id) {
            return response()->json([
                'success' => false,
                'message' => 'Service id is required',
            ], 400);
        }

        $service = $company->services()->find($request->service_id);

        if(!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
            ], 404);
        }

        $request->merge(['service' => $service]);

        return $next($request);
    }
}
