<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\RefreshTokenController;
use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\FeeController;
use App\Http\Controllers\Api\V1\TeacherController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\SectionController;
use App\Http\Middleware\EnsureTokenIsValid;





// Route::prefix('v1')->middleware(['auth:api', EnsureTokenIsValid::class])->group(function () {
Route::prefix('v1')->middleware(["auth:api"])->group(function () {
        // Common Apis start
        Route::get('years-month', [FeeController::class, 'sessionMonthWithYears']);
        Route::get('fee-frequency', [FeeController::class, 'FeeFrequency']);
        // Common Apis End

        // Route::get('employees/search', [EmployeeController::class, 'search']);
        // Route::apiResource('employees', EmployeeController::class);
        // Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('student', StudentController::class);
        Route::get('student-lists', [StudentController::class,"studentLists"]);

        Route::prefix('attendance')->group(function () {
            Route::post('mark', [AttendanceController::class, 'markAttendance']);
            Route::post('mark-bulk', [AttendanceController::class, 'markAttendanceBulk']);
            Route::get('get-attendance', [AttendanceController::class, 'getAttendance']); 
            Route::get('today-attendance-summary', [AttendanceController::class, 'getTodayAttendanceSummary']); 
        });

        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index']);
        });

        Route::prefix('auth')->group(function () {
            Route::get('me', [LoginController::class, 'me']);   
        });
                  
        Route::prefix('fee')->group(function () {
            Route::apiResource('/', FeeController::class);
            Route::get('invoices-list', [FeeController::class, 'getFeeInvoices']);
            Route::get('types', [FeeController::class, 'getFeeTypes']);
        });
        
        Route::prefix('teacher-management')->group(function () {
            Route::apiResource('/teacher', TeacherController::class);
            Route::get('status-update', [TeacherController::class, 'statusUpdate']); 
            Route::get('teacher-details', [TeacherController::class, 'teacherDetails']); 
        });

        Route::prefix('/admin')->group(function () {
            Route::apiResource('/class', ClassController::class);
            Route::apiResource('/section', SectionController::class);
            // Route::post('/assigne-class-section', [TeacherController::class,"assigneClassSection"]);
            Route::get('/class-with-section', [ClassController::class,"getClassesWithSections"]);
            Route::prefix('/fee-type')->group(function () {
                Route::get('/lists', [FeeController::class,"feeTypeLists"]);
                Route::post('/store', [FeeController::class,"feeTypeStore"]);
                Route::put('/update', [FeeController::class,"feeTypeUpdate"]);
                Route::put('/status-update', [FeeController::class,"feeTypeStatusUpdate"]);
            });
        });
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

