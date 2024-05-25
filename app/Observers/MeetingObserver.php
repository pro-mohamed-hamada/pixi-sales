<?php

namespace App\Observers;

use App\Enum\ClientActivityActionEnum;
use App\Models\Meeting;

class MeetingObserver
{
    /**
     * Handle the Meeting "created" event.
     */
    public function created(Meeting $meeting): void
    {
        $meeting->activities()->create([ 'client_id'=>$meeting->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
    }

    /**
     * Handle the Meeting "updated" event.
     */
    public function updated(Meeting $meeting): void
    {
        $meeting->activities()->create([ 'client_id'=>$meeting->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
    }

    /**
     * Handle the Meeting "deleted" event.
     */
    public function deleted(Meeting $meeting): void
    {
        $meeting->activities()->create([ 'client_id'=>$meeting->client->id, 'action'=>ClientActivityActionEnum::DELETED]);
    }

    /**
     * Handle the Meeting "restored" event.
     */
    public function restored(Meeting $meeting): void
    {
        //
    }

    /**
     * Handle the Meeting "force deleted" event.
     */
    public function forceDeleted(Meeting $meeting): void
    {
        //
    }
}
