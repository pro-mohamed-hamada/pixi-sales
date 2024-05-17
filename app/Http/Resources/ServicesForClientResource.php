<?php

namespace App\Http\Resources;

use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesForClientResource extends JsonResource
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
            "name"=>$this->name,
            "price"=>$this->pivot->price,
            "currency"=>$this->pivot->currency,
            "next_action"=>$this->pivot->next_action,
            "next_action_date"=>$this->pivot->next_action_date,
            "comment"=>$this->pivot->comment,
        ];
    }
}
