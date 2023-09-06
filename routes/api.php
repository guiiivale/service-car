<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
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

Route::middleware('valid.user')->group(function () {

    Route::middleware('valid.customer')->group(function () {
        Route::prefix('/vehicles')->group(function () {
            Route::post('/add', [VehiclesController::class, 'add']);
            Route::get('/all', [VehiclesController::class, 'getAll']);
            
            Route::middleware('valid.vehicle')->group(function () {
                Route::put('/edit', [VehiclesController::class, 'edit']);
                Route::get('/get', [VehiclesController::class, 'get']);
                Route::delete('/remove', [VehiclesController::class, 'remove']);
            });
        });

        Route::middleware('valid.company')->group(function () {
            Route::middleware('valid.appointment')->group(function () {
                Route::prefix('/review')->group(function () {
                    Route::post('/add', [ReviewController::class, 'add']);
                });
            });

            Route::middleware('valid.vehicle', 'valid.service')->group(function () {
                Route::prefix('/appointments')->group(function () {
                    Route::post('/store', [AppointmentsController::class, 'store']);
                });
            });
        });

        Route::prefix('/appointments')->group(function () {
            Route::get('/user', [AppointmentsController::class, 'userAppointments']);
        });
    });
    
    Route::prefix('/user')->group(function () {
        Route::put('/reset-token', [UserController::class, 'resetToken']);
        Route::put('/reset-password', [UserController::class, 'resetPassword']);
    });
});

Route::middleware('valid.company')->group(function () {
    Route::prefix('/company')->group(function () {
        Route::post('/select-services', [CompanyController::class, 'selectServices']);
        Route::delete('/remove-services', [CompanyController::class, 'removeServices']);
    });
    Route::prefix('/review')->group(function () {
        Route::get('/get', [ReviewController::class, 'get']);
    });
    Route::prefix('/appointments')->group(function () {
        Route::get('/company', [AppointmentsController::class, 'companyAppointments']);
    });
});


Route::prefix('/user')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/get', [UserController::class, 'get']);
    Route::get('/all', [UserController::class, 'getAll']);
    Route::put('/save', [UserController::class, 'save']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
});

Route::prefix('/services')->group(function () {
    Route::get('/get', [ServicesController::class, 'get']);
    Route::get('/all', [ServicesController::class, 'getAll']);
});
