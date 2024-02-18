<?php

namespace App\Observers;

use App\Models\ClientHistory;

class ClientHistoryObserver
{
    /**
     * Handle the ClientHistory "created" event.
     */
    public function created(ClientHistory $clientHistory): void
    {
        $user = auth("sanctum")->user();
        // $user->targets->
        
    }

    /**
     * Handle the ClientHistory "updated" event.
     */
    public function updated(ClientHistory $clientHistory): void
    {
        //
    }

    /**
     * Handle the ClientHistory "deleted" event.
     */
    public function deleted(ClientHistory $clientHistory): void
    {
        //
    }

    /**
     * Handle the ClientHistory "restored" event.
     */
    public function restored(ClientHistory $clientHistory): void
    {
        //
    }

    /**
     * Handle the ClientHistory "force deleted" event.
     */
    public function forceDeleted(ClientHistory $clientHistory): void
    {
        //
    }
}
