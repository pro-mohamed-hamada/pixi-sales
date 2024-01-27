<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ClientsController;
use App\Http\Controllers\Web\ActivityLogsController;
use App\Http\Controllers\Web\VisitsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'dashboard','middleware'=>'auth'], function(){
    Route::resource('clients', ClientsController::class);
    Route::resource('visits', VisitsController::class);
    Route::resource('activity-logs', ActivityLogsController::class);
});