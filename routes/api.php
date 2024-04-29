<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallsController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\ClientHistoriesController;
use App\Http\Controllers\Api\GovernoratesController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\ClientServicesController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\IndustriesController;
use App\Http\Controllers\Api\MeetingsController;
use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\VisitsController;
use App\Http\Controllers\Api\ReasonsController;
use App\Http\Controllers\Api\SourcesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\WhatsappMessagesController;
use App\Http\Controllers\Api\WhatsappTemplatesController;

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

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('profile-logo', [AuthController::class, 'updateProfileLogo']);
    Route::get('home', [HomeController::class, 'index']);
    Route::get('user/tasks', [HomeController::class, 'tasks']);
    Route::get('users', [UsersController::class, 'index']);
    Route::get('user-recent-activities', [UsersController::class, 'recentActivities']);
    Route::put('task/done-undo/{id}', [HomeController::class, 'doneUndoTask']);
    Route::put('task/reschedule/{id}', [HomeController::class, 'taskReschedule']);
    Route::get('countries', [CountriesController::class, 'index']);
    Route::get('governorates', [GovernoratesController::class, 'index']);
    Route::get('cities', [CitiesController::class, 'index']);
    Route::resource('clients', ClientsController::class);
    Route::get('client-activities/{id}', [ClientsController::class, 'clientActivities']);
    Route::get('clients-on-call', [ClientsController::class, 'getClientOnCall']);
    Route::put('client-reassign/{id}', [ClientsController::class, 'reassignClient']);
    Route::post('clients/change-status/{id}', [ClientsController::class, 'changeStatus']);

    Route::get('services', [ServicesController::class, 'index']);
    Route::post('client/services', [ClientServicesController::class, 'store']);
    Route::delete('client/services/{id}', [ClientServicesController::class, 'destroy']);
    Route::get('client/services/getall', [ClientServicesController::class, 'index']);

    Route::resource('visits',  VisitsController::class);
    Route::post('logout',      [AuthController::class, 'logout']);
    Route::post('start-work',      [AuthController::class, 'startWork']);
    Route::post('end-work',      [AuthController::class, 'endWork']);
    Route::get('authuser',      [AuthController::class, 'authUser']);
    // Route::get('user/target',  [AuthController::class, 'userTarget']);
    Route::get('reasons', [ReasonsController::class, 'index']);
    Route::get('sources', [SourcesController::class, 'index']);
    Route::get('industries', [IndustriesController::class, 'index']);
    Route::resource('calls', CallsController::class)->except('edit', 'show');
    Route::resource('meetings', MeetingsController::class)->except('edit', 'show');
    Route::get('whatsapp-templates', WhatsappTemplatesController::class);
    Route::resource('whatsapp-messages', WhatsappMessagesController::class)->except(['show', 'update', 'edit', 'create']);

    Route::get('notifications', [NotificationsController::class, 'index']);
    Route::delete('notifications/{id}', [NotificationsController::class, 'destroy']);
    Route::put('notifications-read/{id}', [NotificationsController::class, 'markAsRead']);

});