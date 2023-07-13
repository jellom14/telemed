<?php

use App\Http\Controllers\HealthProfileController;
use App\Http\Controllers\MetaDrugAllergiesController;
use App\Http\Controllers\MetaMedicalConditionsController;
use App\Http\Controllers\MetaSurgeriesController;
use App\Http\Controllers\MetaSymptomsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DoctorQualificationsController,
    DoctorSpecialitiesController,
    CaderController,
    UserController,
    AppointmentController,
    MessagesController
};
use JSend\JSendResponse;


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

// Unprotected routes
Route::post('/createAccount', [UserController::class, 'createAccount']);
Route::post('/signIn', [UserController::class, 'signIn']);
Route::get('/doctorQualifications', [DoctorQualificationsController::class, 'getDoctorQualifications']);
Route::get('/doctorSpecialities', [DoctorSpecialitiesController::class, 'getDoctorSpecialities']);

Route::post('/createMessages', [MessagesController::class, 'createMessages']);
Route::post('/test', function () {
    return 'Success';
});
// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // CADERS
    Route::get('/caders', [CaderController::class, 'getCaders']);
    Route::get('/doctorsByCaderId', [UserController::class, 'getDoctorsByCaderId']);
    Route::get('/symptoms', [MetaSymptomsController::class, 'getSymptoms']);
    Route::get('/medicalConditions', [MetaMedicalConditionsController::class, 'getMedicalConditions']);
    Route::get('/drugAllergies', [MetaDrugAllergiesController::class, 'getDrugAllergies']);
    Route::get('/surgeries', [MetaSurgeriesController::class, 'getSurgeries']);
    Route::post('/createHealthProfile', [HealthProfileController::class, 'createHealthProfile']);
    Route::post('/bookAppointment', [AppointmentController::class, 'createAppointment']);
    Route::get('/appointmentByDate', [AppointmentController::class, 'getAppointmentByDate']);
    Route::get('/conversationsByUserId', [MessagesController::class, 'getConversationsByUserId']);
    Route::get('/messagesByConversationId', [MessagesController::class, 'getMessagesByConversationId']);

 
  
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('role')->group(function(){
//     Route::post('post', [RoleController::class, 'post']);
//     Route::put('{id}/put', [RoleController::class, 'put']);
//     Route::get('{id}/get', [RoleController::class, 'get']);
//     Route::delete('{id}/delete', [RoleController::class, 'delete']);

//     Route::get('/', [RoleController::class, 'index']);
// });

// Route::prefix('staff')->group(function(){
//     Route::post('post', [StaffController::class, 'post']);
//     Route::put('{id}/put', [StaffController::class, 'put']);
//     Route::get('{id}/get', [StaffController::class, 'get']);
//     Route::delete('{id}/delete', [StaffController::class, 'delete']);

//     Route::get('/', [StaffController::class, 'index']);
// });

// Route::prefix('patient')->group(function(){
//     Route::post('post', [PatientController::class, 'post']);
//     Route::put('{id}/put', [PatientController::class, 'put']);
//     Route::get('{id}/get', [PatientController::class, 'get']);
//     Route::delete('{id}/delete', [PatientController::class, 'delete']);

//     Route::get('/', [PatientController::class, 'index']);
// });

// Route::prefix('service')->group(function(){
//     Route::post('post', [ServiceController::class, 'post']);
//     Route::put('{id}/put', [ServiceController::class, 'put']);
//     Route::get('{id}/get', [ServiceController::class, 'get']);
//     Route::delete('{id}/delete', [ServiceController::class, 'delete']);

//     Route::get('/', [ServiceController::class, 'index']);
// });

// Route::prefix('mode')->group(function(){
//     Route::post('post', [ModeController::class, 'post']);
//     Route::put('{id}/put', [ModeController::class, 'put']);
//     Route::get('{id}/get', [ModeController::class, 'get']);
//     Route::delete('{id}/delete', [ModeController::class, 'delete']);

//     Route::get('/', [ModeController::class, 'index']);
// });

// Route::prefix('appointment')->group(function(){
//     Route::post('post', [AppointmentController::class, 'post']);
//     Route::put('{id}/put', [AppointmentController::class, 'put']);
//     Route::get('{id}/get', [AppointmentController::class, 'get']);
//     Route::delete('{id}/delete', [AppointmentController::class, 'delete']);

//     Route::get('/', [AppointmentController::class, 'index']);
// });

// Route::prefix('message')->group(function(){
//     Route::post('post', [MessageController::class, 'post']);
//     Route::put('{id}/put', [MessageController::class, 'put']);
//     Route::get('{id}/get', [MessageController::class, 'get']);
//     Route::delete('{id}/delete', [MessageController::class, 'delete']);

//     Route::get('/', [MessageController::class, 'index']);
// });

Route::fallback(function () {
    $messages['message'] = 'Sorry. You are unauthorised to access this page.';
    return JSendResponse::fail($messages);
});