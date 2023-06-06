<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    StaffController,
    PatientController
};

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

Route::prefix('role')->group(function(){
    Route::post('post', [RoleController::class, 'post']);
    Route::put('{id}/put', [RoleController::class, 'put']);
    Route::get('{id}/get', [RoleController::class, 'get']);
    Route::delete('{id}/delete', [RoleController::class, 'delete']);

    Route::get('/', [RoleController::class, 'index']);
});

Route::prefix('staff')->group(function(){
    Route::post('post', [StaffController::class, 'post']);
    Route::put('{id}/put', [StaffController::class, 'put']);
    Route::get('{id}/get', [StaffController::class, 'get']);
    Route::delete('{id}/delete', [StaffController::class, 'delete']);

    Route::get('/', [StaffController::class, 'index']);
});

Route::prefix('patient')->group(function(){
    Route::post('post', [PatientController::class, 'post']);
    Route::put('{id}/put', [PatientController::class, 'put']);
    Route::get('{id}/get', [PatientController::class, 'get']);
    Route::delete('{id}/delete', [PatientController::class, 'delete']);

    Route::get('/', [PatientController::class, 'index']);
});