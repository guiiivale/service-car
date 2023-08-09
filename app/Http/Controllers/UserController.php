<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\GetAllUsersRequest;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetTokenRequest;
use App\Http\Requests\UserSaveRequest;
use App\Jobs\ClearUserExpiredTokenJob;
use Illuminate\Support\Str;
use App\Models\CompanyCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getAll(GetAllUsersRequest $request)
    {
        $data = $request->validated();

        $users = User::with('userType', 'companyCategory', 'services', 'addresses', 'vehicles');

        if ($data['type'] == 'companies') {
            $users = $users->companies()->get();
        } elseif ($data['type'] == 'users') {
            $users = $users->users()->get();
        } elseif ($data['type'] == 'company_categories') {
            $companyCategory = CompanyCategory::find($data['company_category_id']);
            $users = $companyCategory->companies()->with('userType', 'companyCategory', 'services', 'addresses')->get();
        } elseif ($data['type'] == 'service') {
            $service = Service::find($data['service_id']);
            $users = $service->users()->with('userType', 'companyCategory', 'services', 'addresses')->get();
        }

        if ($users->isEmpty()) {
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

        if (isset($data['email'])) $user = User::where('email', $data['email'])->with('userType', 'companyCategory', 'services', 'vehicles', 'addresses')->get();
        if (isset($data['id'])) $user = User::with('userType', 'companyCategory', 'services', 'vehicles', 'addresses')->find($data['id']);

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

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['id']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong password, please try again.',
            ], 400);
        }

        $user->password = $data['new_password'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Change password success',
        ]);
    }

    public function resetToken(ResetTokenRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['id']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $randomToken = Str::random(16);
        $user->reset_password_token = $randomToken;
        $user->save();

        ClearUserExpiredTokenJob::dispatch($user->id)->delay(now()->addMinutes(30));

        $data2 = ['token' => $randomToken];

        Mail::send('emails.reset_token', $data2, function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Seu token para trocar a senha - Service Car');
        });

        return response()->json([
            'success' => true,
            'message' => 'Reset token generated successfully.',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request) 
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if ($user->reset_password_token != $data['token']) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid.',
            ], 400);
        }

        $user->password = $data['new_password'];
        $user->reset_password_token = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }

    public function save(UserSaveRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['id'])->everything()->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $user->update($data);

        if (isset($data['address'])) {
            $addressData = $data['address'];
            if (isset($addressData['id'])) {
                $address = $user->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                }
            } else {
                $address = $user->addresses()->create($addressData);
            }
        
            if ($addressData['is_main']) {
                $user->addresses()->where('id', '!=', $address->id)->update(['is_main' => false]);
            }
        }

        $user = User::find($data['id'])->everything()->first();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user,
        ]);
    }
}
