<?php

namespace App\Observers;

use App\Enum\ClientActivityActionEnum;
use App\Models\WhatsappMessage;

class WhatsappMessageObserver
{
    /**
     * Handle the WhatsappMessage "created" event.
     */
    public function created(WhatsappMessage $whatsappMessage): void
    {
        $whatsappMessage->activities()->create([ 'client_id'=>$whatsappMessage->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
    }

    /**
     * Handle the WhatsappMessage "updated" event.
     */
    public function updated(WhatsappMessage $whatsappMessage): void
    {
        $whatsappMessage->activities()->create([ 'client_id'=>$whatsappMessage->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
    }

    /**
     * Handle the WhatsappMessage "deleted" event.
     */
    public function deleted(WhatsappMessage $whatsappMessage): void
    {
        $whatsappMessage->activities()->create([ 'client_id'=>$whatsappMessage->client->id, 'action'=>ClientActivityActionEnum::DELETED]);
    }

    /**
     * Handle the WhatsappMessage "restored" event.
     */
    public function restored(WhatsappMessage $whatsappMessage): void
    {
        //
    }

    /**
     * Handle the WhatsappMessage "force deleted" event.
     */
    public function forceDeleted(WhatsappMessage $whatsappMessage): void
    {
        //
    }
}
