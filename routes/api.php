<?php

use App\Http\Controllers\PetController1;
use App\Http\Controllers\TreatmentController1;
use App\Http\Controllers\userController1;
use App\Http\Controllers\VetController1;
use App\Http\Controllers\clinicController1;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthControllerClnc;
use App\Http\Controllers\AuthControllerVets;
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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//jwt
Route::group([
//Route::middleware('auth:api')->group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('loginuser', [AuthController::class, 'login']);
    Route::post('logoutuser', [AuthController::class, 'logout']);
    Route::post('registeruser', [AuthController::class, 'register']);
    Route::post('refreshuser', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::group([
    'prefix' => 'user'
    ], function ($router) {
    
    Route::get('showPets', [userController1::class, 'showPets']);
    
});
/*
Route::group(['middleware' => 'api','prefix'=>'api', 'namespace'=>'App\Http\Controllers'], 
    function() {
        Route::apiResource('users', userController1::class);
        Route::apiResource('pets', PetController1::class);
        Route::apiResource('vets', VetController1::class);
        Route::apiResource('visits', TreatmentController1::class);
    }
);
*/

//jwt clinicas veterinarias
Route::group([
    //'middleware' => 'apiclnc',
    'prefix' => 'auth'
    ], function ($router) {
    
    Route::post('loginclinic', [AuthControllerClnc::class, 'loginc']);
    Route::post('logoutclinic', [AuthControllerClnc::class, 'logoutc']);
    Route::post('registerclinic', [AuthControllerClnc::class, 'registerc']);
    Route::post('refreshclinic', [AuthControllerClnc::class, 'refreshc']);
    Route::post('meclinic', [AuthControllerClnc::class, 'mec']);
    
});
Route::group([
    'prefix' => 'clnc'
    ], function ($router) {
    
    Route::get('showVets', [clinicController1::class, 'showVets']);
    
});

//jwt vets
Route::group([
    //'middleware' => 'api',
    'prefix' => 'auth'
    ], function ($router) {
    
    Route::post('loginvet', [AuthControllerVets::class, 'loginv']);
    Route::post('logoutvet', [AuthControllerVets::class, 'logoutv']);
    Route::post('registervet', [AuthControllerVets::class, 'registerv']);
    Route::post('refreshvet', [AuthControllerVets::class, 'refreshv']);
    Route::post('mevet', [AuthControllerVets::class, 'mev']);
    
});

Route::group([
    'prefix' => 'vet'
    ], function ($router) {
    
    Route::get('showTratamientos', [VetController1::class, 'showTrats']);
    
});

