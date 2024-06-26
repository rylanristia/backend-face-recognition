<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessioncheckController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\SendController;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [RegisterController::class, 'register']);
Route::post('auth/session/check', [SessioncheckController::class, 'tokenCheck']);

Route::post('employee/get-all', [EmployeeController::class, 'getAll']);
Route::post('employee/create', [EmployeeController::class, 'createEmployee']);
Route::post('employee/check', [EmployeeController::class, 'checkEmployee']);
Route::post('employee/set/attendance', [AttendanceController::class, 'attendance']);

Route::post('employee/report', [ReportController::class, 'index']);