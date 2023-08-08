<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/user')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/get', [UserController::class, 'get']);
    Route::get('/all', [UserController::class, 'getAll']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
    Route::put('/reset-token', [UserController::class, 'resetToken']);
    Route::put('/reset-password', [UserController::class, 'resetPassword']);
});

Route::prefix('/vehicles')->group(function () {
    Route::post('/add', [VehiclesController::class, 'add']);
    Route::put('/edit', [VehiclesController::class, 'edit']);
    Route::delete('/remove', [VehiclesController::class, 'remove']);
});

Route::prefix('/services')->group(function () {
    Route::get('/get', [ServicesController::class, 'get']);
    Route::get('/all', [ServicesController::class, 'getAll']);
});

Route::prefix('/company')->group(function () {
    Route::post('/select-services', [CompanyController::class, 'selectServices']);
    Route::delete('/remove-services', [CompanyController::class, 'removeServices']);
});