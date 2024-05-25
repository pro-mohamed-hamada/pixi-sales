<?php

namespace App\Providers;

use App\Models\Call;
use App\Models\ClientService;
use App\Models\Meeting;
use App\Models\Visit;
use App\Models\WhatsappMessage;
use App\Observers\CallObserver;
use App\Observers\ClientServiceObserver;
use App\Observers\MeetingObserver;
use App\Observers\VisitObserver;
use App\Observers\WhatsappMessageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Visit::observe(VisitObserver::class);
        Call::observe(CallObserver::class);
        Meeting::observe(MeetingObserver::class);
        WhatsappMessage::observe(WhatsappMessageObserver::class);
    }
}
