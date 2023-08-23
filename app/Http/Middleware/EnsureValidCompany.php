<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserTypes;

class EnsureValidCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->company_id) {
            return response()->json([
                'success' => false,
                'message' => 'Company ID not provided',
            ], 400);
        }

        $company = User::find($request->company_id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if($company->user_type_id != UserTypes::COMPANY_ID) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a company',
            ], 400);
        }

        $request->merge(['company' => $company]);

        return $next($request);
    }
}
