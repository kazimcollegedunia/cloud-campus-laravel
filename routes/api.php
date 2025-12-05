<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\RefreshTokenController;


Route::get('/test', function () {
    return response()->json(['message' => 'API working!']);
});


Route::prefix('v1')->group(function () {
    Route::get('employees/search', [EmployeeController::class, 'search']);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('student', StudentController::class);
    Route::get('all-class', [StudentController::class, 'getClass']);
    Route::get('all-section', [StudentController::class,'getSection']);
});


// Route::middleware(['tenant'])->group(function () {

    Route::prefix('v1/auth')->group(function () {

        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
        Route::post('reset-password', [ResetPasswordController::class, 'reset']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [LogoutController::class, 'logout']);
            Route::post('refresh', [RefreshTokenController::class, 'refresh']);
        });

    });

// });

