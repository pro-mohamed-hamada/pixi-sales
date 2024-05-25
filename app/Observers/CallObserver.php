<?php

namespace App\Observers;

use App\Enum\ClientActivityActionEnum;
use App\Models\Call;

class CallObserver
{
    /**
     * Handle the Call "created" event.
     */
    public function created(Call $call): void
    {
        $call->activities()->create([ 'client_id'=>$call->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
    }

    /**
     * Handle the Call "updated" event.
     */
    public function updated(Call $call): void
    {
        $call->activities()->create([ 'client_id'=>$call->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
    }

    /**
     * Handle the Call "deleted" event.
     */
    public function deleted(Call $call): void
    {
        $call->activities()->create([ 'client_id'=>$call->client->id, 'action'=>ClientActivityActionEnum::DELETED]);
    }

    /**
     * Handle the Call "restored" event.
     */
    public function restored(Call $call): void
    {
        //
    }

    /**
     * Handle the Call "force deleted" event.
     */
    public function forceDeleted(Call $call): void
    {
        //
    }
}
