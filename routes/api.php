<?php

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

Route::post('/user/register', [App\Http\Controllers\Api\UserApiController::class, 'register']);
Route::post('/user/login', [App\Http\Controllers\Api\UserApiController::class, 'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/location', [App\Http\Controllers\Api\AttendanceApiController::class, 'getLocationList']);
    Route::post('/location', [App\Http\Controllers\Api\AttendanceApiController::class, 'postLocation']);
    Route::post('/user/change-master-location', [App\Http\Controllers\Api\AttendanceApiController::class, 'postLocation']);
    Route::get('/attendance', [App\Http\Controllers\Api\AttendanceApiController::class, 'getAttendanceList']);
    Route::post('/attendance', [App\Http\Controllers\Api\AttendanceApiController::class, 'postAttendance']);
});