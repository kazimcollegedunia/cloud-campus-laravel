<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\StudentController;


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
