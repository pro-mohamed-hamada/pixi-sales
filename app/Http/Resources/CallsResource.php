<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallsResource extends JsonResource
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
            'next_action_date'=>$this->next_action_date,
            'next_action_note'=>$this->next_action_note,
        ];
    }
}
