<?php

namespace App\Observers;

use App\Enum\ClientActivityActionEnum;
use App\Models\Visit;

class VisitObserver
{
    /**
     * Handle the Visit "created" event.
     */
    public function created(Visit $visit): void
    {
        $visit->activities()->create([ 'client_id'=>$visit->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
    }

    /**
     * Handle the Visit "updated" event.
     */
    public function updated(Visit $visit): void
    {
        $visit->activities()->create([ 'client_id'=>$visit->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
    }

    /**
     * Handle the Visit "deleted" event.
     */
    public function deleted(Visit $visit): void
    {
        $visit->activities()->create([ 'client_id'=>$visit->client->id, 'action'=>ClientActivityActionEnum::DELETED]);
    }

    /**
     * Handle the Visit "restored" event.
     */
    public function restored(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "force deleted" event.
     */
    public function forceDeleted(Visit $visit): void
    {
        //
    }
}
