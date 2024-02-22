<?php

use App\Http\Controllers\Web\CitiesController;
use App\Http\Controllers\Web\GovernoratesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ClientsController;
use App\Http\Controllers\Web\ActivityLogsController;
use App\Http\Controllers\Web\CallsController;
use App\Http\Controllers\Web\MeetingsController;
use App\Http\Controllers\Web\ReasonsController;
use App\Http\Controllers\Web\ServicesController;
use App\Http\Controllers\Web\TargetsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\VisitsController;
use App\Http\Controllers\Web\WhatsappTemplatesController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'dashboard','middleware'=>'auth'], function(){
    Route::resource('clients', ClientsController::class);
    Route::resource('calls', CallsController::class)->except('show');
    Route::resource('meetings', MeetingsController::class)->except('show');
    Route::post('clients/change-status/{id}', [ClientsController::class, 'changeStatus'])->name("clients.changeStatus");
    Route::post('clients/services/{id}', [ClientsController::class, 'clientServices'])->name("clients.clientServices");
    Route::resource('visits', VisitsController::class);
    Route::resource('activity-logs', ActivityLogsController::class);
    Route::resource('governorates', GovernoratesController::class);
    Route::resource('cities', CitiesController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('reasons', ReasonsController::class);
    Route::resource('targets', TargetsController::class);
    Route::resource('users', UsersController::class);
    Route::resource('whatsapp-templates', WhatsappTemplatesController::class);
});