<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = new User($data);
        $user->userType()->associate($data['user_type_id']);
        if(isset($data['company_category_id'])) $user->companyCategory()->associate($data['company_category_id']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Register success',
            'data' => $user
        ]);
    }
}
