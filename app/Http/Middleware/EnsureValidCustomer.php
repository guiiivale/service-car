<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = $request->user;

        if($customer->user_type_id != UserTypes::USER_ID) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a customer',
            ], 400);
        }

        $request->merge(['customer' => $customer]);

        return $next($request);
    }
}
