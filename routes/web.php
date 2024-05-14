<?php

use App\Http\Controllers\Web\SourcesController;
use App\Http\Controllers\Web\CitiesController;
use App\Http\Controllers\Web\GovernoratesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ClientsController;
use App\Http\Controllers\Web\ActivityLogsController;
use App\Http\Controllers\Web\CallsController;
use App\Http\Controllers\Web\CountriesController;
use App\Http\Controllers\Web\FcmMessagesController;
use App\Http\Controllers\Web\IndustriesController;
use App\Http\Controllers\Web\LocalizationController;
use App\Http\Controllers\Web\MeetingsController;
use App\Http\Controllers\Web\ReasonsController;
use App\Http\Controllers\Web\ScheduleFcmController;
use App\Http\Controllers\Web\ServicesController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\VisitsController;
use App\Http\Controllers\Web\WhatsappTemplatesController;
use App\Http\Controllers\Web\WhatsappMessagesController;
use App\Models\Client;
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

Route::get('/test', function(){
    $client = Client::first();
    return formatPhone(phone: "+21152204422", slug: $client?->city?->governorate?->country?->slug);

});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'dashboard','middleware'=>'auth'], function(){
    Route::get('profile', [UsersController::class, 'profileView'])->name('profile.view');
    Route::put('profile', [UsersController::class, 'profile'])->name('profile.update');
    Route::resource('clients', ClientsController::class);
    Route::get('clients-import', [ClientsController::class, 'importView'])->name('clients.import_view');
    Route::post('clients-import', [ClientsController::class, 'import'])->name('clients.import');
    Route::get('client-visits/{id}', [ClientsController::class, 'clientVisits'])->name('client.visits');
    Route::get('client-activities/{id}', [ClientsController::class, 'clientActivities'])->name('client.activities');
    Route::resource('calls', CallsController::class)->except('show');
    Route::resource('meetings', MeetingsController::class)->except('show');
    Route::post('clients/change-status/{id}', [ClientsController::class, 'changeStatus'])->name("clients.changeStatus");
    Route::resource('visits', VisitsController::class);
    Route::resource('activity-logs', ActivityLogsController::class);
    Route::resource('countries', CountriesController::class);
    Route::resource('governorates', GovernoratesController::class);
    Route::resource('cities', CitiesController::class);
    Route::get('governorates-ajax', [GovernoratesController::class, 'governoratesAjax'])->name('governorates.ajax');
    Route::get('cities-ajax', [CitiesController::class, 'citiesAjax'])->name('cities.ajax');
    Route::resource('services', ServicesController::class);
    Route::resource('reasons', ReasonsController::class);
    Route::resource('industries', IndustriesController::class);
    Route::resource('sources', SourcesController::class);
    Route::resource('users', UsersController::class);
    Route::get('user-targets/{id}', [UsersController::class, 'userTargets'])->name('user.targets');
    Route::post('user-targets', [UsersController::class, 'userTargets'])->name('users.target');
    Route::resource('whatsapp-templates', WhatsappTemplatesController::class);
    Route::resource('whatsapp-messages', WhatsappMessagesController::class)->except(['update', 'edit', 'show']);

    Route::resource('fcm-messages', FcmMessagesController::class)->except('show');
    Route::get('live-fcm', [FcmMessagesController::class, 'liveFcmMessageView'])->name('fcm.liveFcmMessageView');
    Route::post('live-fcm', [FcmMessagesController::class, 'liveFcmMessage'])->name('fcm.liveFcmMessage');
    Route::resource('schedule-fcm', ScheduleFcmController::class)->except('show');

    Route::get('lang/{locale}',LocalizationController::class)->name('lang');
});