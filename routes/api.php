<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\GovernoratesController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\VisitsController;
use App\Http\Controllers\Api\ReasonsController;

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

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware'=>['auth:sanctum', 'localization']], function(){
    Route::get('governorates', [GovernoratesController::class, 'index']);
    Route::get('cities', [CitiesController::class, 'index']);
    Route::resource('clients', ClientsController::class);
    Route::resource('visits',  VisitsController::class);
    Route::post('logout',      [AuthController::class, 'logout']);
    Route::get('authuser',      [AuthController::class, 'authUser']);
    Route::get('services', [ServicesController::class, 'index']);
    Route::get('reasons', [ReasonsController::class, 'index']);
});