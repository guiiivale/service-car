<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllUsersRequest;
use App\Http\Requests\GetUserRequest;
use App\Models\CompanyCategory;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll(GetAllUsersRequest $request)
    {
        $data = $request->validated();

        $users = User::with('userType', 'companyCategory')->get();
        if($data['type'] == 'companies') $users = User::where('user_type_id', 1)->with('userType', 'companyCategory')->get();
        if($data['type'] == 'users') $users = User::where('user_type_id', 2)->with('userType', 'companyCategory')->get();
        if($data['type'] == 'company_categories') $users = CompanyCategory::find($data['company_category_id'])->companies()->with('userType', 'companyCategory')->get();

        if($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Users not found',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Get all users success',
            'users' => $users,
        ]);
    }

    public function get(GetUserRequest $request)
    {
        $data = $request->validated();

        if (isset($data['email'])) $user = User::where('email', $data['email'])->with('userType', 'companyCategory')->get();
        if (isset($data['id'])) $user = User::with('userType', 'companyCategory')->find($data['id']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get user success',
            'users' => $user,
        ]);
    }
}
