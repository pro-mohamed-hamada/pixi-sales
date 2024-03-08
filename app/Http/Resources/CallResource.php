<?php

namespace App\Http\Resources;

use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
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
            'type'=>$this->type,
            'status'=>$this->status,
            'date'=>$this->date,
            'comment'=>$this->comment,
            'next_action'=>$this->next_action,
            'next_action_date'=>$this->next_action_date,
        ];
    }
}
