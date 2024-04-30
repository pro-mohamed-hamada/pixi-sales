<?php

namespace App\Http\Resources;

use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientServicesForClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->service->name,
            "price"=>$this->price,
            "next_action"=>$this->next_action,
            "next_action_date"=>$this->next_action_date,
            "comment"=>$this->comment,
        ];
    }
}
